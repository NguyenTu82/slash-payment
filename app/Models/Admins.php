<?php

namespace App\Models;

use App\Enums\NotiStatusReceive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissions;
use App\Traits\HasUuid;

class Admins extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasPermissions;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'admins';

    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'name',
        'email',
        'password',
        'email_verified_at',
        'token',
        'expires_at',
        'account_id',
        'role_id',
        'note'
    ];

    /** The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['have_unread_notification'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(AdminRole::class, 'role_id');
    }

    public function getHaveUnreadNotificationAttribute(): bool
    {
        return EpayReceiveNoti::query()
            ->where('status', NotiStatusReceive::UNREAD->value)
            ->exists();
    }
}
