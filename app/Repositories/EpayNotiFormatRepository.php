<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EpayFormatNotiRepository.
 *
 * @package namespace App\Repositories;
 */
interface EpayNotiFormatRepository extends RepositoryInterface
{
    public function getAllNotiTemplate();
}
