<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CryptoWithdrawAccount.
 *
 * @package namespace App\Models;
 */
class CryptoWithdrawAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'crypto_withdraw_accounts';
    protected $keyType = "string";

    protected $fillable = [
        'merchant_store_id',
        'asset',
        'wallet_address',
        'network',
        'note',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $visible = [];

}
