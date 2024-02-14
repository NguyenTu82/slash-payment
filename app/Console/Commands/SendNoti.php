<?php

namespace App\Console\Commands;

use App\Enums\MerchantNotiStatus;
use App\Repositories\MerchantStoreRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Repositories\EpayNotiSendRepository;
use App\Jobs\SendEmailJob;
use App\Mail\Notification;
use App\Enums\NotiStatusSend;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class SendNoti extends Command
{
    protected $signature = "SendNoti";
    protected $description = "Send email to user 1 minute";

    public function handle(): void
    {
        try {
            $epayNotiSendRepository = app()->make(EpayNotiSendRepository::class);
            $merchantStoreRepository = app()->make(MerchantStoreRepository::class);
            $notifications = $epayNotiSendRepository->getScheduleSend();
            foreach ($notifications as $value) {
                if (is_null($value->merchant_receive_list)) {
                    $merchantStores = $merchantStoreRepository->getAllMerchantStores();
                } else {
                    $merchantStoreIds = explode(',', $value->merchant_receive_list);
                    $merchantStores = $merchantStoreRepository->getMerchantStoresByIds($merchantStoreIds);
                }

                $arrayDB = [];
                foreach ($merchantStores as  $merchantStore) {
                    try {
                        $arrayDB [] = [
                            'merchant_id' => $merchantStore->id,
                            'send_date' => Carbon::now(),
                            'title' => $value->title,
                            'content' => $value->content,
                            'type' => $value->type,
                            'status' => MerchantNotiStatus::UNREAD->value,
                        ];

                        if (!empty($merchant->delivery_email_address1)) {
                            SendEmailJob::dispatch(new Notification($value->content, $value->title),  $merchant->delivery_email_address1)
                                ->onQueue('emails');
                        }
                        if (!empty($merchant->delivery_email_address2)) {
                            SendEmailJob::dispatch(new Notification($value->content, $value->title), $merchant->delivery_email_address2)
                                ->onQueue('emails');
                        }
                        if (!empty($merchant->delivery_email_address3)) {
                            SendEmailJob::dispatch(new Notification($value->content, $value->title), $merchant->delivery_email_address3)
                                ->onQueue('emails');
                        }
                        SendEmailJob::dispatch(new Notification($value->content, $value->title), $merchantStore->merchantOwner->email)
                            ->onQueue('emails');
                    } catch (Exception $e) {
                        Log::error("JOB-ERROR:" . $e->getMessage());
                    }
                }

                DB::beginTransaction();
                DB::table('merchant_notification')->insert($arrayDB);
                $epayNotiSendRepository->update([
                    'status' => NotiStatusSend::SEND->value,
                    'actual_send_date' => Carbon::now(),
                ], $value->id);
                DB::commit();
            }
        } catch (Exception $e) {
            Log::error("JOB-ERROR:" . $e->getMessage());
        }
    }
}
