<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EpayNotiRepository.
 *
 * @package namespace App\Repositories;
 */
interface EpayNotiSendRepository extends RepositoryInterface
{
    public function getListSend($request);
    public function getScheduleSend();
}
