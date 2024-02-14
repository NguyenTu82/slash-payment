<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MerchantStore.
 *
 * @package namespace App\Models;
 */
class PaymentSuccess extends Model implements Transformable
{
    use TransformableTrait, HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'payment_success';
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_history_id',
        'merchant_store_id',
        'payment_amount',
        'payment_asset',
        'received_amount',
        'received_asset',
        'network',
        'request_method',
    ];

    public function TransactionHistories(): BelongsTo
    {
    return $this->belongsTo(TransactionHistory::class, 'transaction_history_id');
}

    public function merchantStore()
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_store_id', 'id');
    }

    public function transactionHistory()
    {
        return $this->belongsTo(TransactionHistory::class, 'transaction_history_id', 'id');
    }
}
