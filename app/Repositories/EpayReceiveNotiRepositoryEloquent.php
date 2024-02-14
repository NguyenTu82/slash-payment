<?php

namespace App\Repositories;

use App\Enums\MerchantStoreStatus;
use App\Models\EpayReceiveNoti;
use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Enums\WithdrawStatus;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EpayReceiveNotiRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EpayReceiveNotiRepositoryEloquent extends BaseRepository implements EpayReceiveNotiRepository
{
    public function model(): string
    {
        return EpayReceiveNoti::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
