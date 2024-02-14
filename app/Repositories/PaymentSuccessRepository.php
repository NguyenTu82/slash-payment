<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PaymentSuccessRepository.
 *
 * @package namespace App\Repositories;
 */
interface PaymentSuccessRepository extends RepositoryInterface
{
    public function totalTransactions($cond);

    public function totalCryptoReceive($cond);

    public function totalReceiveSuccessOfMerchantStoreByAsset($merchantStoreId, $asset, $time);

    public function totalPaymentSuccessOfMerchantStoreByAsset($merchantStoreId, $asset, $time);

    public function totalBalanceOfMerchantStore($merchantStoreId, $type);

    public function paymentSuccessStatistic($cond);

    public function getCountAmount($merchantId, $paymentAsset, $time);

    public function getQueryPaymentSuccessByType($request, $type);

    public function totalPaymentAmountForReport($merchant_store_id, $period_from, $period_to);

    public function totalRecivedAmountForReport($merchant_store_id, $period_from, $period_to);

    public function totalPaymentAndRecivedAmount($merchant_store_id, $asset, $time1);
}
