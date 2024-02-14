<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScreenPermissionRoles extends Model
{
    use HasFactory;

    protected $table = "screen_permission_roles";

    protected $guarded = [];

    /**
     * @var mixed fillable
     */
    protected $fillable = ["screen_id", "permission_id", "role_id", "active"];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var null
     */
    protected $primaryKey = null;

    /**
     * @var bool
     */
    public $incrementing = false;

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, "role_id", "id");
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screens::class, "screen_id", "id");
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, "permission_id", "id");
    }
}
