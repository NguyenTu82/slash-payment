<?php

namespace App\Repositories;
use App\Models\Group;
use Prettus\Repository\Eloquent\BaseRepository;
/**
 * Class GroupMerchantRepositoryEloquent.
 *
 * @package
 *
 */

class GroupMerchantRepositoryEloquent extends BaseRepository implements GroupMerchantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Group::class;
    }

    public function deleteByParentIdAndChildrenId($parentId, $childrenId)
    {
        $this->model
            ->where([['merchant_parent_store_id' , '=', $parentId], ['merchant_children_store_id', '=', $childrenId]])
            ->delete();
    }
}
