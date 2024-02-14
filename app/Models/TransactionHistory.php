<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHistory extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'transaction_histories';

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant_store_id',
        'transaction_date',
        'payment_amount',
        'payment_asset',
        'received_amount',
        'received_asset',
        'network',
        'request_method',
        'payment_status',
        'payment_success_datetime',
        'payment_due_datetime',
        'hash',
        'order_code',
        'callback_logs',
    ];

    public function paymentSuccess(): HasOne
    {
    return $this->hasOne(PaymentSuccess::class, 'transaction_history_id');
}

    public function merchantStore()
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_store_id', 'id');
    }
}
