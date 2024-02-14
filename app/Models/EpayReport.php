<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EpayReport.
 *
 * @package namespace App\Models;
 */
class EpayReport extends Model implements Transformable
{
    use TransformableTrait;
    use HasUuid;
    use SoftDeletes;

    protected $table = 'epay_reports';

    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'report_code',
        'merchant_store_id',
        'period_from',
        'period_to',
        'issue_date',
        'send_email',
        'note',
        'status',
        'type',
        'payment_amount',
        'received_amount',
        'withdraw_amount',
        'pdf_link'
    ];

    protected $casts = [
        'period_from' => 'datetime',
        'period_to' => 'datetime',
        'issue_date' => 'datetime',
    ];

    public function merchantStore(): BelongsTo
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_store_id', 'id');
    }
}
