<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantStoreRepository.
 *
 * @package namespace App\Repositories;
 */
interface EpayWithdrawRepository extends RepositoryInterface
{
    public function getHistories($filter);

    public function totalMoneyWithdraw($cond);

    public function withdrawStatistic($cond);

    public function getWithdrawHistory($id);
}
