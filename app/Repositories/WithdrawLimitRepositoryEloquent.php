<?php

namespace App\Repositories;

use App\Models\WithdrawLimit;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class MerchantStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WithdrawLimitRepositoryEloquent extends BaseRepository implements WithdrawLimitRepository
{
    public function model(): string
    {
        return WithdrawLimit::class;
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
