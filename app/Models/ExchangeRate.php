<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MerchantStore.
 *
 * @package namespace App\Models;
 */
class ExchangeRate extends Model implements Transformable
{
    use HasUuid;
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'exchange_rates';

    protected $keyType = "string";

    protected $fillable = [
        'merchant_store_id',
        'jpy_jpy',
        'usdc_jpy',
        'usdt_jpy',
        'dai_jpy',
        'jpyc_jpy',
    ];

}