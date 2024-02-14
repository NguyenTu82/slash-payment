<?php

namespace App\Models;

use App\Traits\HasPermissions;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MerchantStore.
 *
 * @package namespace App\Models;
 */
class MerchantGroup extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'merchant_groups';
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant_store_id',
        'merchant_user_id',
    ];

    protected $visible = [];

    public function store(): BelongsTo
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_store_id');
    }
}
