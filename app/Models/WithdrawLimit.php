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
class WithdrawLimit extends Model implements Transformable
{
    use HasUuid;
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'withdraw_limits';

}
