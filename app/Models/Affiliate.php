<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Affiliate.
 *
 * @package namespace App\Models;
 */
class Affiliate extends Model implements Transformable
{
    use TransformableTrait;
    protected $table = 'affiliates';
    protected $keyType = "string";
}
