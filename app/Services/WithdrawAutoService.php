<?php

namespace App\Services;

use App\Enums\MerchantStorePaymentCycle;
use App\Enums\MerchantStoreStatus;
use App\Enums\NotiTypeReceive;
use App\Enums\WithdrawAsset;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawRequestMethod;
use App\Enums\WithdrawStatus;
use App\Events\NeedSendMail;
use App\Models\SlashApi;
use App\Repositories\CryptoWithdrawAccountRepository;
use App\Repositories\FiatWithdrawAccountRepository;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\WithdrawRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WithdrawAutoService
{
    protected Carbon $period_from;

    protected Carbon $period_to;

    protected int $paymentCycle;

    public function __construct(Carbon $periodFrom, Carbon $periodTo, int $paymentCycle)
    {
        $this->period_from = $periodFrom;
        $this->period_to = $periodTo;
        $this->paymentCycle = $paymentCycle;
    }

    public function handle(): void
    {
        try {
            $merchantStoreRepository = app()->make(MerchantStoreRepository::class);
            $withdrawRepository = app()->make(WithdrawRepository::class);
            $fiatWithdrawAccountRepository = app()->make(FiatWithdrawAccountRepository::class);
            $cryptoWithdrawAccountRepository = app()->make(CryptoWithdrawAccountRepository::class);
            $balanceService = app()->make(BalanceService::class);
            $withdrawLimitService = app()->make(WithdrawLimitService::class);
            $withdrawLimits = $withdrawLimitService->getWithdrawLimitList();

            $dataMerchantStores = $merchantStoreRepository->where([
                'payment_cycle' => $this->paymentCycle,
                'status' => MerchantStoreStatus::IN_USE->value,
            ])->get();

            foreach ($dataMerchantStores as $merchantStore) {
                try {
                    $withdrawMethod = $merchantStore->withdraw_method;
                    $countNumber = $withdrawRepository->where('merchant_store_id', $merchantStore->id)->count();
                    $orderId = formatAccountId($merchantStore->merchant_code) . Carbon::now()->format('_Ymd_') . $countNumber + 1;

                    switch ($withdrawMethod) {
                        // 現金 & 銀行振込の場合
                        case WithdrawMethod::CASH->value:
                        case WithdrawMethod::BANKING->value:
                            $balance = $balanceService->getBalanceSummary($merchantStore->id, WithdrawAsset::JPY->value);
                            $limitInfo = $withdrawLimits->where('asset', WithdrawAsset::JPY->value)->first();
                            if ($balance >= $limitInfo->once_min_withdraw) { // 現在時点で残高確認
                                $bankInfo = $fiatWithdrawAccountRepository->findByField('merchant_store_id', $merchantStore->id)->first();

                                if (empty($bankInfo))
                                    break;

                                $withdrawRequest = [
                                    'merchant_store_id' => $merchantStore->id,
                                    'withdraw_method' => $withdrawMethod,
                                    'withdraw_request_method' => WithdrawRequestMethod::AUTO->value,
                                    'withdraw_status' => WithdrawStatus::WAITING_APPROVE->value,
                                    'amount' => str_replace(',', '', formatNumberInt($balance)),
                                    'asset' => WithdrawAsset::JPY->value,
                                    'fee' => 0,
                                    'fee_asset' => WithdrawAsset::JPY->value,
                                    'hash' => Str::uuid()->toString(),
                                    'withdraw_name' => $bankInfo->financial_institution_name . ' ' . $bankInfo->bank_account_number,
                                    'period_from' => $this->period_from,
                                    'period_to' => $this->period_to,
                                    'order_id' => $orderId,
                                ];

                                if ($withdrawMethod == WithdrawMethod::BANKING->value)
                                    $withdrawRequest['bank_info'] = $bankInfo;

                                $result = $withdrawRepository->create($withdrawRequest);

                                if ($result) {
                                    event(new NeedSendMail($result, NotiTypeReceive::WITHDRAWAL->value));
                                }
                            }
                            break;
                        // 仮想通貨の場合
                        case WithdrawMethod::CRYPTO->value:
                            $slashInfo = SlashApi::query()->where('merchant_store_id', $merchantStore->id)->first();

                            if (empty($slashInfo))
                                break;

                            $balance = $balanceService->getBalanceSummary($merchantStore->id, $slashInfo->receive_crypto_type);
                            $limitInfo = $withdrawLimits->where('asset', $slashInfo->receive_crypto_type)->first();

                            if ($balance >= $limitInfo->once_min_withdraw) { // 現在時点で残高確認
                                $cryptoInfo = $cryptoWithdrawAccountRepository->findByField('merchant_store_id', $merchantStore->id)->first();
                                $withdrawRequest = [
                                    'merchant_store_id' => $merchantStore->id,
                                    'withdraw_method' => $withdrawMethod,
                                    'withdraw_request_method' => WithdrawRequestMethod::AUTO->value,
                                    'withdraw_status' => WithdrawStatus::WAITING_APPROVE->value,
                                    'amount' => str_replace(',', '', formatNumberDecimal($balance)),
                                    'asset' => $slashInfo->receive_crypto_type,
                                    'fee' => 0,
                                    'fee_asset' => $slashInfo->receive_crypto_type,
                                    'hash' => Str::uuid()->toString(),
                                    'withdraw_name' => $cryptoInfo->network . ' ' . $cryptoInfo->wallet_address,
                                    'crypto_info' => $cryptoInfo,
                                    'period_from' => $this->period_from,
                                    'period_to' => $this->period_to,
                                    'order_id' => $orderId,
                                ];
                                $result = $withdrawRepository->create($withdrawRequest);

                                if ($result) {
                                    event(new NeedSendMail($result, NotiTypeReceive::WITHDRAWAL->value));
                                }
                            }
                            break;
                    }
                } catch (Exception $e) {
                    dump($e->getMessage());
                    Log::error('WEEKLY-WITHDRAW-JOB-ERROR:' . $e->getMessage());
                }
            }
        } catch (Exception $e) {
            dump($e->getMessage());
            Log::error("WEEKLY-WITHDRAW-JOB-ERROR:" . $e->getMessage());
        }
    }
}
