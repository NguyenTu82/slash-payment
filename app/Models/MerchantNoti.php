<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MerchantNoti.
 *
 * @package namespace App\Models;
 */
class MerchantNoti extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'merchant_notification';

    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant_id',
        'epay_sent_noti_id',
        'send_date',
        'title',
        'content',
        'type',
        'status',
    ];

    public function merchantStore(): BelongsTo
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_id');
    }
}
