<?php

namespace App\Services\Epay;

use App\Enums\MerchantNotiStatus;
use App\Enums\NotiTypeSend;
use App\Jobs\SendEmailJob;
use App\Mail\Notification;
use App\Repositories\EpayNotiFormatRepositoryEloquent;
use App\Repositories\EpayNotiRepository;
use App\Repositories\EpayNotiSendRepository;
use App\Repositories\EpayNotiFormatRepository;
use App\Enums\NotiStatusReceive;
use App\Repositories\MerchantStoreRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\MerchantNotificationRepository;
use App\Enums\NotiStatusSend;
use Carbon\Carbon;

class NotificationService
{
    private EpayNotiFormatRepositoryEloquent $epayNotiFormatRepositoryEloquent;
    protected EpayNotiRepository $epayNotiRepository;
    protected EpayNotiSendRepository $epayNotiSendRepository;
    protected EpayNotiFormatRepository $epayNotiFormatRepository;
    protected MerchantNotificationRepository $merchantNotificationRepository;
    protected MerchantStoreRepository $merchantStoreRepository;

    public function __construct(
        EpayNotiFormatRepositoryEloquent $epayNotiFormatRepositoryEloquent,
        EpayNotiRepository       $epayNotiRepository,
        EpayNotiSendRepository   $epayNotiSendRepository,
        EpayNotiFormatRepository $epayNotiFormatRepository,
        MerchantNotificationRepository $merchantNotificationRepository,
        MerchantStoreRepository $merchantStoreRepository,
    )
    {
        $this->epayNotiFormatRepositoryEloquent = $epayNotiFormatRepositoryEloquent;
        $this->epayNotiRepository = $epayNotiRepository;
        $this->epayNotiSendRepository = $epayNotiSendRepository;
        $this->epayNotiFormatRepository = $epayNotiFormatRepository;
        $this->merchantNotificationRepository = $merchantNotificationRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
    }

    public function listReceive($request)
    {
        return $this->epayNotiRepository->getListReceive($request);
    }

    public function listSend($request)
    {
        return $this->epayNotiSendRepository->getListSend($request);
    }

    public function getReceivedNotiDetail($id)
    {
        return $this->epayNotiRepository->getReceivedNotiDetail($id);
    }

    public function deleteReceivedNotiById($id)
    {
        return $this->epayNotiRepository->deleteReceivedNotiById($id);
    }

    public function updateNotiStatusWhenOpen($id)
    {
        try {
            $merchantNoti = $this->epayNotiRepository->update(["status" => NotiStatusReceive::ALREADY_READ->value], $id);
            DB::commit();
            return $merchantNoti;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
        }
    }

    public function getAllNotiTemplate()
    {
        return $this->epayNotiFormatRepository->getAllNotiTemplate();
    }

    public function updateNotiTemplate($data, $id): array
    {
        DB::beginTransaction();
        try {
            $this->epayNotiFormatRepositoryEloquent->update(
                $data,
                $id
            );
            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "message" => $e->getMessage(),
            ];

        }
    }

    public function createNotificationSendToMerchant($request): void
    {
        DB::beginTransaction();
        try {
            $isSendToMerchantList = $request->merchant_all_or_part;
            $selectedStoresText = null;

            if ($isSendToMerchantList == NotiTypeSend::PART->value)
                $selectedStoresText = implode(',', $request->merchant_store_ids);

            if (isset($request->is_has_send_time)) {
                $sendStatus = NotiStatusSend::UNSEND->value;
                $sendTimeReal = $request->schedule_send_date;
            } else {
                $sendStatus = NotiStatusSend::SEND->value;
                $sendTimeReal = Carbon::now();
            }
            $dataNoti = [
                "merchant_receive_list" => $selectedStoresText,
                "schedule_send_date" => $sendTimeReal,
                "title" => $request->title,
                "content" => $request->content,
                "type" => $request->merchant_all_or_part,
                "status" => $sendStatus,
            ];
            if ($sendStatus == NotiStatusSend::SEND->value) {
                $dataNoti["actual_send_date"] = $sendTimeReal;
            }
            $notificationContent = $this->epayNotiSendRepository->create($dataNoti);

            // 送信時間指定無しの場合、すぐ送信進む
            if ($sendStatus == NotiStatusSend::SEND->value) {
                if (is_null($selectedStoresText)) {
                    $merchantUsers = $this->merchantStoreRepository->getAllMerchantStores();
                } else {
                    $merchantUsers = $this->merchantStoreRepository->getMerchantStoresByIds($request->merchant_store_ids);
                }

                // メール送信してからDB履歴保存
                $receiveList = $merchantUsers->map(function ($user) use ($request) {
                    try {
                        SendEmailJob::dispatch(new Notification($request->content, $request->title), $user->merchantOwner->email)
                            ->onQueue('emails');
                        return [
                            'merchant_id' => $user->id,
                            'send_date' => Carbon::now(),
                            'title' => $request->title,
                            'content' => $request->content,
                            'type' => $request->merchant_all_or_part,
                            'status' => MerchantNotiStatus::UNREAD->value,
                        ];
                    } catch (Exception $e) {
                        Log::error("INIT-SEND-MAIL-ERROR:" . $e->getMessage());
                        return [];
                    }
                })->reject(function ($notification) { // 不具合発生の場合
                    return empty($notification);
                })->all();

                if (!empty($receiveList))
                    $notificationContent->receiveNotifications()->sync($receiveList);
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
        }
    }

    public function getSendNotiDetail($id)
    {
        $data = $this->epayNotiSendRepository->find($id);
        $merchantStoreIds = !empty($data->merchant_receive_list) ? explode(',', $data->merchant_receive_list) : [];
        $dataMerchant = $this->merchantStoreRepository->findWhereIn("id",$merchantStoreIds);

        $data["dataMerchantName"] = $dataMerchant->pluck("name");
        $data["dataMerchantId"] = $dataMerchant->pluck("id")->toArray();
        return $data;
    }

    public function editNotificationSendToMerchant($request,$id)
    {
        DB::beginTransaction();
        try {
            $isSendToMerchantList = $request->merchant_all_or_part;
            $selectedStoresText = null;

            if ($isSendToMerchantList == NotiTypeSend::PART->value)
                $selectedStoresText = implode(',', $request->merchant_store_ids);

            if (isset($request->is_has_send_time)) {
                $sendStatus = NotiStatusSend::UNSEND->value;
                $sendTimeReal = $request->schedule_send_date;
            } else {
                $sendStatus = NotiStatusSend::SEND->value;
                $sendTimeReal = Carbon::now();
            }
            $dataNoti = [
                "merchant_receive_list" => $selectedStoresText,
                "schedule_send_date" => $sendTimeReal,
                "title" => $request->title,
                "content" => $request->content,
                "type" => $request->merchant_all_or_part,
                "status" => $sendStatus,
            ];
            if ($sendStatus == NotiStatusSend::SEND->value) {
                $dataNoti["actual_send_date"] = $sendTimeReal;
            }
            $notificationContent = $this->epayNotiSendRepository->update($dataNoti,$id);

            // 送信時間指定無しの場合、すぐ送信進む
            if ($sendStatus == NotiStatusSend::SEND->value) {
                if (is_null($selectedStoresText)) {
                    $merchantUsers = $this->merchantStoreRepository->getAllMerchantStores();
                } else {
                    $merchantUsers = $this->merchantStoreRepository->getMerchantStoresByIds($request->merchant_store_ids);
                }

                // メール送信してからDB履歴保存
                $receiveList = $merchantUsers->map(function ($user) use ($request) {
                    try {
                        SendEmailJob::dispatch(new Notification($request->content, $request->title), $user->merchantOwner->email)
                            ->onQueue('emails');
                        return [
                            'merchant_id' => $user->id,
                            'send_date' => Carbon::now(),
                            'title' => $request->title,
                            'content' => $request->content,
                            'type' => $request->merchant_all_or_part,
                            'status' => MerchantNotiStatus::UNREAD->value,
                        ];
                    } catch (Exception $e) {
                        Log::error("INIT-SEND-MAIL-ERROR:" . $e->getMessage());
                        return [];
                    }
                })->reject(function ($notification) { // 不具合発生の場合
                    return empty($notification);
                })->all();

                if (!empty($receiveList))
                    $notificationContent->receiveNotifications()->sync($receiveList);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }
    }
    public function deleteSendNotiById($id)
    {
        return $this->epayNotiSendRepository->delete($id);
    }
}
