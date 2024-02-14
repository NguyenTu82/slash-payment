<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasUuid;

class AdminTokens extends Authenticatable
{
    use HasFactory;
    use HasUuid;

    protected $table = "admin_tokens";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["email", "token", "valid_at"];

    /**
     * List all field need to encrypt
     *
     * @var string[]
     */
    public array $encryptable = ["email"];

    public $timestamps = true;
}
