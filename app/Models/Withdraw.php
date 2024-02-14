<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MerchantStore.
 *
 * @package namespace App\Models;
 */
class Withdraw extends Model implements Transformable
{
    use HasUuid;
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'withdraws';
    protected $keyType = "string";
    protected $dates = ['approve_datetime', 'created_at', 'updated_at'];
    protected $casts = [
        'bank_info' => 'array',
        'crypto_info' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'merchant_store_id',
        'admin_approve_id',
        'withdraw_method',
        'withdraw_request_method',
        'withdraw_status',
        'amount',
        'asset',
        'fee',
        'fee_asset',
        'hash',
        'fiat_withdraw_account_id',
        'crypto_withdraw_account_id',
        'approve_datetime',
        'company_member_code',
        'note',
        'bank_info',
        'crypto_info',
        'withdraw_name',
        'period_from',
        'period_to',
        'tgw_log',
    ];

    public function merchantStore()
    {
        return $this->belongsTo(MerchantStore::class, 'merchant_store_id', 'id');
    }
}
