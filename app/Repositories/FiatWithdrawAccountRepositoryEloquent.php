<?php

namespace App\Repositories;
use App\Models\FiatWithdrawAccount;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Enums\AdminAccountStatus;
/**
 * Class FiatWithdrawAccountRepositoryEloquent.
 *
 * @package
 *
 */

class FiatWithdrawAccountRepositoryEloquent extends BaseRepository implements FiatWithdrawAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FiatWithdrawAccount::class;
    }
}
