<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasUuid;

class MerchantToken extends Authenticatable
{
    use HasFactory;
    use HasUuid;

    protected $table = "merchant_tokens";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["email", "token", "valid_at"];

    public $timestamps = true;
}
