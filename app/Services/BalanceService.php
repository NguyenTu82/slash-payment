<?php

namespace App\Services;

use App\Enums\WithdrawAsset;
use App\Models\MerchantStore;
use App\Repositories\PaymentSuccessRepository;
use App\Repositories\WithdrawRepository;
use App\Repositories\ExchangeRateRepository;
// use App\Services\ExchangeRateRepository;
use Illuminate\Support\Facades\Log;

class BalanceService
{
    protected PaymentSuccessRepository $paymentSuccessRepository;

    protected WithdrawRepository $withdrawRepository;

    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(
        PaymentSuccessRepository $paymentSuccessRepository,
        WithdrawRepository $withdrawRepository,
        ExchangeRateRepository $exchangeRateRepository,
    ) {
        $this->paymentSuccessRepository = $paymentSuccessRepository;
        $this->withdrawRepository = $withdrawRepository;
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function getCurrentBalance(MerchantStore $merchantStore, $asset, $time = null)
    {
        $merchantStoreId = $merchantStore->id;
        if ($asset == WithdrawAsset::JPY->value)
            $totalBalance = $this->paymentSuccessRepository->totalPaymentSuccessOfMerchantStoreByAsset($merchantStoreId, $asset, $time);
        else
            $totalBalance = $this->paymentSuccessRepository->totalReceiveSuccessOfMerchantStoreByAsset($merchantStoreId, $asset, $time);

        $balanceIsUsed = $this->withdrawRepository->getBalanceIsUsedByAsset($merchantStoreId, $asset);

        return $totalBalance - $balanceIsUsed;
    }

    public function getBalanceSummary($merchantStoreId, $asset = null)
    {
        // get total withdraw of Yen, Crypto
        $totalWithdraw = $this->withdrawRepository->totalWithdraw($merchantStoreId);
        $totalWithdrawYen = $totalWithdraw->where('asset', WithdrawAsset::JPY->value)->first()->total ?? 0;
        $totalWithdrawUSDT = $totalWithdraw->where('asset', WithdrawAsset::USDT->value)->first()->total ?? 0;
        $totalWithdrawUSDC = $totalWithdraw->where('asset', WithdrawAsset::USDC->value)->first()->total ?? 0;
        $totalWithdrawDAI = $totalWithdraw->where('asset', WithdrawAsset::DAI->value)->first()->total ?? 0;
        $totalWithdrawJPYC = $totalWithdraw->where('asset', WithdrawAsset::JPYC->value)->first()->total ?? 0;

        // get total balance withdraw of Yen, Crypto
        $totalBalanceYen = $this->paymentSuccessRepository->totalBalanceOfMerchantStore($merchantStoreId, $type = "payment_asset");
        $totalBalanceYen = $totalBalanceYen[0]->total_amount ?? 0;

        $totalBalanceCrypto = $this->paymentSuccessRepository->totalBalanceOfMerchantStore($merchantStoreId, $type = "received_asset");
        $totalBalanceUSDT = $totalBalanceCrypto->where('received_asset', WithdrawAsset::USDT->value)->first()->total_amount ?? 0;
        $totalBalanceUSDC = $totalBalanceCrypto->where('received_asset', WithdrawAsset::USDC->value)->first()->total_amount ?? 0;
        $totalBalanceDAI = $totalBalanceCrypto->where('received_asset', WithdrawAsset::DAI->value)->first()->total_amount ?? 0;
        $totalBalanceJPYC = $totalBalanceCrypto->where('received_asset', WithdrawAsset::JPYC->value)->first()->total_amount ?? 0;

        // get exchange rate of Yen, Crypto
        $exchangeRatesUSDT_JPY = $this->exchangeRateRepository->where('merchant_store_id', $merchantStoreId)->first()->usdt_jpy ?? 0;
        $exchangeRatesUSDC_JPY = $this->exchangeRateRepository->where('merchant_store_id', $merchantStoreId)->first()->usdc_jpy ?? 0;
        $exchangeRatesDAI_JPY = $this->exchangeRateRepository->where('merchant_store_id', $merchantStoreId)->first()->dai_jpy ?? 0;
        $exchangeRatesJPYC_JPY = $this->exchangeRateRepository->where('merchant_store_id', $merchantStoreId)->first()->jpyc_jpy ?? 0;

        //calculation total crypto average
        $totalCryptoAverage = (($totalBalanceUSDT - $totalWithdrawUSDT) * $exchangeRatesUSDT_JPY) + (($totalBalanceUSDC - $totalWithdrawUSDC) * $exchangeRatesUSDC_JPY) +
            (($totalBalanceDAI - $totalWithdrawDAI) * $exchangeRatesDAI_JPY) + (($totalBalanceJPYC - $totalWithdrawJPYC) * $exchangeRatesJPYC_JPY);

        if (!empty($totalCryptoAverage)) {
            //Calculate the average for each type
            $averageUSDT = (($totalBalanceUSDT - $totalWithdrawUSDT) * $exchangeRatesUSDT_JPY) / $totalCryptoAverage;
            $averageUSDC = (($totalBalanceUSDC - $totalWithdrawUSDC) * $exchangeRatesUSDC_JPY) / $totalCryptoAverage;
            $averageDAI = (($totalBalanceDAI - $totalWithdrawDAI) * $exchangeRatesDAI_JPY) / $totalCryptoAverage;
            $averageJPYC = (($totalBalanceJPYC - $totalWithdrawJPYC) * $exchangeRatesJPYC_JPY) / $totalCryptoAverage;

            // get total balance remain withdraw of Yen, Crypto
            $totalRemainYen = $totalBalanceYen - $totalWithdrawYen - ($totalWithdrawUSDT * $exchangeRatesUSDT_JPY) - ($totalWithdrawUSDC * $exchangeRatesUSDC_JPY) - ($totalWithdrawDAI * $exchangeRatesDAI_JPY) - ($totalWithdrawJPYC * $exchangeRatesJPYC_JPY);
            $totalRemainYen = $totalRemainYen > 0 ? $totalRemainYen : 0;
            $totalRemainUSDT = !empty($exchangeRatesUSDT_JPY) ? ($totalBalanceUSDT - $totalWithdrawUSDT - ($totalWithdrawYen * $averageUSDT / $exchangeRatesUSDT_JPY)) : 0;
            $totalRemainUSDT = $totalRemainUSDT > 0 ? $totalRemainUSDT : 0;
            $totalRemainUSDC = !empty($exchangeRatesUSDC_JPY) ? ($totalBalanceUSDC - $totalWithdrawUSDC - ($totalWithdrawYen * $averageUSDC / $exchangeRatesUSDC_JPY)) : 0;
            $totalRemainUSDC = $totalRemainUSDC > 0 ? $totalRemainUSDC : 0;
            $totalRemainDAI = !empty($exchangeRatesDAI_JPY) ? ($totalBalanceDAI - $totalWithdrawDAI - ($totalWithdrawYen * $averageDAI / $exchangeRatesDAI_JPY)) : 0;
            $totalRemainDAI = $totalRemainDAI > 0 ? $totalRemainDAI : 0;
            $totalRemainJPYC = !empty($exchangeRatesJPYC_JPY) ? ($totalBalanceJPYC - $totalWithdrawJPYC - ($totalWithdrawYen * $averageJPYC / $exchangeRatesJPYC_JPY)) : 0;
            $totalRemainJPYC = $totalRemainJPYC > 0 ? $totalRemainJPYC : 0;
        } else {
            $totalRemainYen = 0;
            $totalRemainUSDT = 0;
            $totalRemainUSDC = 0;
            $totalRemainDAI = 0;
            $totalRemainJPYC = 0;

        }

        if (empty($asset))
            return [
                'balanceYen' => formatNumberInt($totalRemainYen),
                'balanceUSDT' => formatNumberDecimal($totalRemainUSDT),
                'balanceUSDC' => formatNumberDecimal($totalRemainUSDC),
                'balanceDAI' => formatNumberDecimal($totalRemainDAI),
                'balanceJPYC' => formatNumberDecimal($totalRemainJPYC),
            ];
        else if ($asset == WithdrawAsset::JPY->value)
            return $totalRemainYen;
        else if ($asset === WithdrawAsset::USDT->value)
            return $totalRemainUSDT;
        else if ($asset === WithdrawAsset::USDC->value)
            return $totalRemainUSDC;
        else if ($asset === WithdrawAsset::DAI->value)
            return $totalRemainDAI;
        else
            return $totalRemainJPYC;
    }
}