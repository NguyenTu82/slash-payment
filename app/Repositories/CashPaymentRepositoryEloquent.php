<?php

namespace App\Repositories;
use App\Models\CashPayment;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Enums\AdminAccountStatus;
/**
 * Class CashPaymentRepositoryEloquent.
 *
 * @package
 *
 */

class CashPaymentRepositoryEloquent extends BaseRepository implements CashPaymentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CashPayment::class;
    }
}
