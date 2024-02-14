<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MerchantRole.
 *
 * @package namespace App\Models;
 */
class MerchantRole extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'merchant_roles';

    protected $keyType = "string";

}
