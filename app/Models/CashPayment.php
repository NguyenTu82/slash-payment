<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CashPayment.
 *
 * @package namespace App\Models;
 */
class CashPayment extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'cash_payments';
    protected $keyType = "string";

    protected $fillable = [
        'merchant_store_id',
        'total_transaction_amount',
        'account_balance',
        'paid_balance',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $visible = [];

}
