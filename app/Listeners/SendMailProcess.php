<?php

namespace App\Listeners;

use App\Enums\MerchantNotiType;
use App\Enums\NotiFromType;
use App\Enums\NotiStatusReceive;
use App\Enums\NotiTypeReceive;
use App\Enums\WithdrawRequestMethod;
use App\Events\NeedSendMail;
use App\Jobs\SendEmailToEpayJob;
use App\Jobs\SendEmailToMerchantJob;
use App\Repositories\EpayReceiveNotiFormRepository;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\MerchantUserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendMailProcess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\NeedSendMail $event
     * @return void
     */
    public function handle(NeedSendMail $event): void
    {
        $epayReceiveNotiFormRepo = app()->make(EpayReceiveNotiFormRepository::class);
        $merchantUserRepo = app()->make(MerchantUserRepository::class);
        $merchantStoreRepo = app()->make(MerchantStoreRepository::class);
        $templateToMerchant = $epayReceiveNotiFormRepo->findWhere([
            'type' => NotiTypeReceive::WITHDRAWAL_ACCEPTED,
            'from_type' => NotiFromType::FROM_EPAY,
        ])->first();

        $templateToEpay = $epayReceiveNotiFormRepo->findWhere([
            'type' => $event->type,
            'from_type' => NotiFromType::FROM_USER,
        ])->first();

        $titleToMerchant = $templateToMerchant->title;
        $titleToEpay = $templateToEpay->title;
        $contentToMerchant = $templateToMerchant->content ?? '';
        $contentToEpay = $templateToEpay->content ?? '';
        $sendDate = null;
        $merchantStoreId = '';
        $contentFormattedToMerchant = '';
        $contentFormattedToEpay = '';
        $merchantOwnerStoreMail = '';

        if ($event->type == NotiTypeReceive::WITHDRAWAL->value) {
            $withdraw = $event->data;
            $merchantStoreName = $withdraw->merchantStore->name ?? '';
            $amount = formatNumberDecimal($withdraw->amount);
            $note = $withdraw->note;
            $withdrawMethod = __('merchant.withdraw.withdraw_method.' . $withdraw->withdraw_method);
            $merchantStoreId = $withdraw->merchant_store_id;
            $sendDate = $withdraw->created_at;

            if ($withdraw->withdraw_request_method == WithdrawRequestMethod::AUTO->value) {
                $periodFrom = Carbon::parse($withdraw->period_from)->format('Y/m/d');
                $periodTo = Carbon::parse($withdraw->period_to)->format('Y/m/d');
                $requestMethod = '自動';
                $period = $periodFrom .' ~ '. $periodTo;
            } else {
                $requestMethod = 'リクエスト';
                $period = '無し';
            }

            // Replace content
            $contentParams = [
                'datetime' => formatDateTimeJapan($withdraw->created_at),
                'request_content' => $note,
                'merchant_name' => $merchantStoreName,
                'amount' => $amount,
                'type' => $withdrawMethod,
                'withdraw_request_method' => $requestMethod,
                'period' => $period
            ];

            $contentFormattedToMerchant = formatContent($contentParams, $contentToMerchant);
            $contentFormattedToEpay = formatContent($contentParams, $contentToEpay);

            // get mail merchant owner
            $merchantStore = $merchantStoreRepo->find($merchantStoreId);
            $merchantOwnerStore = $merchantUserRepo->find($merchantStore->merchant_user_owner_id);
            $merchantOwnerStoreMail = $merchantOwnerStore->email;
        } elseif ($event->type == NotiTypeReceive::NEW_REGISTER->value) {
            // Todo: Process for new_merchant
        } else {
            // Todo: Process for merchant_cancel
        }

        // base notification data
        $baseNotiData = [
            'merchant_id' => $merchantStoreId,
            'send_date' => $sendDate,
            'status' => NotiStatusReceive::UNREAD->value,
        ];

        // merchant processing
        $merchantReceiveNotiData = array_merge($baseNotiData, [
            'format_type_id' => $templateToMerchant->id,
            'title' => $titleToMerchant,
            'content' => $contentFormattedToMerchant,
            'type' => MerchantNotiType::WITHDRAW->value,
        ]);
        $sendMailMerchantData = [
            'toEmail' => $merchantOwnerStoreMail,
            'title' => $titleToMerchant,
            'content' => $contentFormattedToMerchant,
            'merchantReceiveNotiData' => $merchantReceiveNotiData,
        ];
        dispatch(new SendEmailToMerchantJob($sendMailMerchantData))->onQueue('emails');

        // Epay processing
        $epayReceiveNotiData = array_merge($baseNotiData, [
            'format_type_id' => $templateToEpay->id,
            'title' => $titleToEpay,
            'content' => $contentFormattedToEpay,
        ]);
        $sendMailEpayData = [
            'title' => $titleToEpay,
            'content' => $contentFormattedToEpay,
            'epayReceiveNotiData' => $epayReceiveNotiData,
        ];

        dispatch(new SendEmailToEpayJob($sendMailEpayData))->onQueue('emails');
    }
}
