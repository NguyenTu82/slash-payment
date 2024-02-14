<?php

namespace App\Repositories;

use App\Models\MerchantGroup;
use App\Enums\MerchantStoreStatus;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class MerchantGroupRepositoryEloquent.
 *
 * @package namespace App\Repositories\Merchant;
 */
class MerchantGroupRepositoryEloquent extends BaseRepository implements MerchantGroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return MerchantGroup::class;
    }

    public function findMerchantStoreByUser()
    {
        return auth('merchant')->user()->merchantStores()
            ->where('merchant_stores.status', MerchantStoreStatus::IN_USE->value)
            ->get();
    }

    public function deleteByStoreIdAndUserId($storeId, $userId)
    {
        $this->model->where([['merchant_store_id', '=', $storeId], ['merchant_user_id', '=', $userId]])
            ->delete();
    }
}
