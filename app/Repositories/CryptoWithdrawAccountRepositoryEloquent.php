<?php

namespace App\Repositories;
use App\Models\CryptoWithdrawAccount;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Enums\AdminAccountStatus;
/**
 * Class CryptoWithdrawAccountRepositoryEloquent.
 *
 * @package
 *
 */

class CryptoWithdrawAccountRepositoryEloquent extends BaseRepository implements CryptoWithdrawAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CryptoWithdrawAccount::class;
    }
}
