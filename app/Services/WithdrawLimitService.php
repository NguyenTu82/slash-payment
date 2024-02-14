<?php

namespace App\Services;

use App\Repositories\WithdrawLimitRepository;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;

class WithdrawLimitService
{
    private WithdrawLimitRepository $withdrawLimitRepository;

    public function __construct(
        WithdrawLimitRepository $withdrawLimitRepository,
    ) {
        $this->withdrawLimitRepository = $withdrawLimitRepository;
    }

    /**
     * @return mixed
     */
    public function getWithdrawLimitList($type = null)
    {
        if ($type) {
            $this->withdrawLimitRepository->findByField("asset_type",$type);
        }
        return $this->withdrawLimitRepository->all();
    }
}
