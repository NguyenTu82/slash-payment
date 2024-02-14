<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EpayReceiveNotiForm.
 *
 * @package namespace App\Models;
 */
class EpayReceiveNotiForm extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'epay_receive_notification_format';
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
    ];

    public function merchantStore(): BelongsTo
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_store_id', 'id');
    }

}
