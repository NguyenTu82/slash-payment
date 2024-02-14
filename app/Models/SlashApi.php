<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SlashApi.
 *
 * @package namespace App\Models;
 */
class SlashApi extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'slash_apis';
    protected $keyType = "string";
    protected $fillable = [
        "merchant_store_id",
        "contract_wallet",
        "receive_wallet_address",
        "receive_crypto_type",
        "slash_auth_token",
        "slash_hash_token"
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $visible = [];

}
