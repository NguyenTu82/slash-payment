<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantStoreRepository.
 *
 * @package namespace App\Repositories;
 */
interface WithdrawRepository extends RepositoryInterface
{
    public function getBalanceIsUsedByAsset($merchantStoreId, $asset);

    public function getHistories($filter);

    public function totalMoneyWithdraw($cond);

    public function totalWithdraw($merchantStoreId);

    public function withdrawStatistic($cond);

    public function getWithdrawHistory($id);

    public function getCountAmount($merchantId, $paymentAsset);

    public function updateStatusWithdraw($status, $Id, $transaction);

    public function totalAmountForReport($merchant_store_id, $period_from, $period_to);
}
