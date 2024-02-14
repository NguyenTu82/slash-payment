<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantRoleRepository.
 *
 * @package namespace App\Repositories;
 */
interface MerchantRoleRepository extends RepositoryInterface
{
    public function getRoles();
    public function getAllRoles();
}
