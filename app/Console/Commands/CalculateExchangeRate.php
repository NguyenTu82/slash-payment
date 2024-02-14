<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\PaymentSuccessRepository;
use App\Repositories\WithdrawRepository;
use App\Repositories\ExchangeRateRepository;
use App\Enums\WithdrawRequestMethod;
use App\Enums\WithdrawAsset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CalculateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CalculateExchangeRate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate exchange rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        try {
            $merchantStoreRepository = app()->make(MerchantStoreRepository::class);
            $paymentSuccessRepository = app()->make(PaymentSuccessRepository::class);
            $withdrawRepository = app()->make(WithdrawRepository::class);
            $exchangeRateRepository = app()->make(ExchangeRateRepository::class);

            $merchantStoreDatas = $merchantStoreRepository->getAllMerchantStores();

            foreach ($merchantStoreDatas as $merchantStore) {
                DB::beginTransaction();
                $merchantID = $merchantStore->id;
                $rateData = [
                    'merchant_store_id' => $merchantID,
                    'jpy_jpy' => 1,
                ];

                $lastDayAutoWithdraw = $withdrawRepository
                    ->where('merchant_store_id', $merchantID)
                    ->where('withdraw_request_method', WithdrawRequestMethod::AUTO->value)
                    ->max('updated_at');

                $paymentSuccessUSDTDatas = $paymentSuccessRepository->totalPaymentAndRecivedAmount($merchantID, WithdrawAsset::USDT->value, $lastDayAutoWithdraw);
                if ($paymentSuccessUSDTDatas->isNotEmpty()){
                    $usdt_jpyRate = $paymentSuccessUSDTDatas[0]->payment_total / $paymentSuccessUSDTDatas[0]->received_total;
                    $rateData = array_merge($rateData,['usdt_jpy' => $usdt_jpyRate]);
                    $result = $exchangeRateRepository->updateOrCreate(['merchant_store_id' => $merchantID], $rateData);
                }

                $paymentSuccessUSDCDatas = $paymentSuccessRepository->totalPaymentAndRecivedAmount($merchantID, WithdrawAsset::USDC->value, $lastDayAutoWithdraw);
                if ($paymentSuccessUSDCDatas->isNotEmpty()){
                    $usdc_jpyRate = $paymentSuccessUSDCDatas[0]->payment_total / $paymentSuccessUSDCDatas[0]->received_total;
                    $rateData = array_merge($rateData,['usdc_jpy' => $usdc_jpyRate]);
                    $result = $exchangeRateRepository->updateOrCreate(['merchant_store_id' => $merchantID], $rateData);
                }

                $paymentSuccessDAIDatas = $paymentSuccessRepository->totalPaymentAndRecivedAmount($merchantID, WithdrawAsset::DAI->value, $lastDayAutoWithdraw);
                if ($paymentSuccessDAIDatas->isNotEmpty()){
                    $dai_jpyRate = $paymentSuccessDAIDatas[0]->payment_total / $paymentSuccessDAIDatas[0]->received_total;
                    $rateData = array_merge($rateData,['dai_jpy' => $dai_jpyRate]);
                    $result = $exchangeRateRepository->updateOrCreate(['merchant_store_id' => $merchantID], $rateData);
                }

                $paymentSuccessJPYCDatas = $paymentSuccessRepository->totalPaymentAndRecivedAmount($merchantID, WithdrawAsset::JPYC->value, $lastDayAutoWithdraw);
                if ($paymentSuccessJPYCDatas->isNotEmpty()){
                    $jpyc_jpyRate = $paymentSuccessJPYCDatas[0]->payment_total / $paymentSuccessJPYCDatas[0]->received_total;
                    $rateData = array_merge($rateData,['jpyc_jpy' => $jpyc_jpyRate]);
                    $result = $exchangeRateRepository->updateOrCreate(['merchant_store_id' => $merchantID], $rateData);
                }
                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("JOB-ERROR:" . $e->getMessage());
        }
    }
}