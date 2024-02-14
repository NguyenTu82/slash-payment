<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantRepository.
 *
 * @package namespace App\Repositories\Merchant;
 */
interface MerchantGroupRepository extends RepositoryInterface
{
    public function findMerchantStoreByUser();
    public function deleteByStoreIdAndUserId($storeId, $userId);
}
