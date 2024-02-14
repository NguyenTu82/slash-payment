<?php

namespace App\Models;

use App\Enums\MerchantNotiStatus;
use App\Enums\MerchantStoreStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MerchantUser extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasPermissions;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'merchant_users';

    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'email_verified_at',
        'merchant_role_id',
        'name',
        'password',
        'phone',
        'remember_token',
        'status',
        'parent_user_id',
        'note'
    ];

    /** The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['have_unread_notification'];

    /**
     * @return BelongsToMany
     */
    public function merchantStores(): BelongsToMany
    {
        return $this->belongsToMany(MerchantStore::class, 'merchant_groups', 'merchant_user_id', 'merchant_store_id')
            ->where('merchant_stores.status', MerchantStoreStatus::IN_USE->value)
            ->whereNull('merchant_groups.deleted_at')
            ->withTimestamps();
    }

    public function getMerchantStore(): BelongsTo
    {
        return $this->belongsTo(MerchantStore::class, 'id', 'merchant_user_owner_id');
    }

    public function getHaveUnreadNotificationAttribute(): bool
    {
        $merchantStoreIds = $this->merchantStores()->pluck('merchant_store_id')->all();
        return MerchantNoti::query()
            ->whereIn('merchant_id', $merchantStoreIds)
            ->where('status', MerchantNotiStatus::UNREAD->value)
            ->exists();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(MerchantRole::class, 'merchant_role_id');
    }
}
