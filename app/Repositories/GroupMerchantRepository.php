<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface GroupMerchantRepository.
 *
 * @package namespace App\Repositories;
 */
interface GroupMerchantRepository extends RepositoryInterface
{
    public function deleteByParentIdAndChildrenId($parentId, $childrenId);
}
