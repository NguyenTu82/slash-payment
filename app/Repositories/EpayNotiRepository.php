<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EpayNotiRepository.
 *
 * @package namespace App\Repositories;
 */
interface EpayNotiRepository extends RepositoryInterface
{
    public function getListReceive($request);
    public function getReceivedNotiDetail($id);
    public function deleteReceivedNotiById($id);

}
