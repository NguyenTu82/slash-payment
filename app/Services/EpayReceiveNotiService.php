<?php

namespace App\Services;

use App\Repositories\EpayReceiveNotiRepositoryEloquent;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;

class EpayReceiveNotiService
{
    private EpayReceiveNotiRepositoryEloquent $epayReceiveNotiRepo;
    public function __construct(
        EpayReceiveNotiRepositoryEloquent $epayReceiveNotiRepo
    ) {
        $this->epayReceiveNotiRepo = $epayReceiveNotiRepo;
    }
}
