<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MerchantRepository.
 *
 * @package namespace App\Repositories\Merchant;
 */
interface AffiliateRepository extends RepositoryInterface
{
    public function totalAffiliates($cond);
}
