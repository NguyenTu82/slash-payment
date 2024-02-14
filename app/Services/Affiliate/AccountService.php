<?php

namespace App\Services\Affiliate;

use App\Repositories\AffiliateRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class AccountService
{
    protected AffiliateRepository $affiliateRepository;

    /**
     *  constructor
     *
     * @param AffiliateRepository $affiliateRepository
     */
    public function __construct(
        AffiliateRepository $affiliateRepository,
    ) {
        $this->affiliateRepository = $affiliateRepository;
    }

    public function totalAffiliates($cond)
    {
        return $this->affiliateRepository->totalAffiliates($cond);
    }
}
