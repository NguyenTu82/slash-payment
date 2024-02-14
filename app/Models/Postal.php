<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Postal.
 *
 * @package namespace App\Models;
 */
class Postal extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'postal';
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $visible = [];

}
