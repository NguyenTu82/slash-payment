<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EpayReportRepository.
 *
 * @package namespace App\Repositories;
 */
interface EpayReportRepository extends RepositoryInterface
{
    public function getList($request);
    public function getReportById($id);
}
