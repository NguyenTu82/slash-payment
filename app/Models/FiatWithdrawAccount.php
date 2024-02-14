<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FiatWithdrawAccount.
 *
 * @package namespace App\Models;
 */
class FiatWithdrawAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fiat_withdraw_accounts';
    protected $keyType = "string";

    protected $fillable = [
        'merchant_store_id',
        'financial_institution_name',
        'bank_code',
        'branch_name',
        'branch_code',
        'bank_account_type',
        'bank_account_number',
        'bank_account_holder',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $visible = [];

}
