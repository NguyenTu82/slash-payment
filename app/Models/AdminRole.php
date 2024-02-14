<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class AdminRole extends Model
{
    use HasUuid;
    public $timestamps = false;

    protected $keyType = "string";

}
