<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TransactionHistoryRepository.
 *
 * @package namespace App\Repositories;
 */
interface TransactionHistoryRepository extends RepositoryInterface
{
    public function findTransactionHistories($request);

    public function transStatistic($cond);
}
