<?php

namespace App\Models;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EpaySendNoti.
 *
 * @package namespace App\Models;
 */
class EpaySendNoti extends Model implements Transformable
{
    use HasUuid;
    use SoftDeletes;

    use TransformableTrait;

    protected $table = 'epay_send_notification';

    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant_receive_list',
        'schedule_send_date',
        'actual_send_date',
        'title',
        'content',
        'type',
        'status',
    ];

    public function receiveNotifications(): BelongsToMany
    {
        return $this->belongsToMany(MerchantNoti::class, 'merchant_notification','epay_sent_noti_id', 'epay_sent_noti_id')
            ->withTimestamps();
    }
}
