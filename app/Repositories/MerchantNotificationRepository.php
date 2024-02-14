<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantNotificationRepository.
 *
 * @package namespace App\Repositories;
 */
interface MerchantNotificationRepository extends RepositoryInterface
{
    //
    public function getNotiByMerchantId($query);
    public function getNotiDetail($id);
    public function deleteNotiById($id);
    public function insert($notifications);
}
