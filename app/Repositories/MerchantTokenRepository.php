<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantRepository.
 *
 * @package namespace App\Repositories\Merchant;
 */
interface MerchantTokenRepository extends RepositoryInterface
{
   public function findMerchantToken($data);
}
