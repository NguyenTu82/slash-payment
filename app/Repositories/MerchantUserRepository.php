<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantRepository.
 *
 * @package namespace App\Repositories\Merchant;
 */
interface MerchantUserRepository extends RepositoryInterface
{
    public function findUserByEmail($email);
    public function getProfile();
    public function getMerchantUsers($request);
    public function findUserById($id);
    public function deleteUserbyId($id);
}
