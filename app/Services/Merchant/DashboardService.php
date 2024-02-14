<?php

namespace App\Services\Merchant;

use App\Models\Merchant;
use App\Repositories\MerchantUserRepository;

class DashboardService
{
    protected MerchantUserRepository $merchantRepository;

    /**
     *  constructor
     *
     * @param MerchantUserRepository $merchantRepository
     */
    public function __construct(
        MerchantUserRepository $merchantRepository
    ){
        $this->merchantRepository = $merchantRepository;
    }

}
