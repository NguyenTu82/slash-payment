<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantStoreRepository.
 *
 * @package namespace App\Repositories;
 */
interface MerchantStoreRepository extends RepositoryInterface
{
    public function getMerchantStores($request);

    public function getAllMerchantStores();

    public function merchantStoreActiveIds();

    public function createMerchantStore($data);

    public function getAllMerchantStoresNotParentWithoutId($id);

    public function getMerchantStoreById($id);

    public function getMerchantStoresByIds($merchantStoreIds);

    public function updateWhenDeleteGroup($id);

    public function totalMerchantStores($cond);

    public function merchantStoreStatistic($cond);

    public function getAllMerchantStoresNotParent();
}
