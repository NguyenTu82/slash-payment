<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\HasUuid;
use App\Enums\WithdrawAsset;

/**
 * Class MerchantStore.
 *
 * @package namespace App\Models;
 */
class MerchantStore extends Model implements Transformable
{
    use TransformableTrait;
    use HasUuid;
    use SoftDeletes;
    protected $table = 'merchant_stores';
    protected $keyType = "string";
    protected $appends = ['total_adjusted_amount'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'affiliate_id',
        'contract_date',
        'contract_interest_rate',
        'contract_wallet',
        'delivery_report',
        'guidance_email',
        'industry',
        'name',
        'withdraw_method',
        'payment_cycle',
        'representative_name',
        'sending_detail',
        'service_name',
        'ship_address',
        'ship_date',
        'status',
        'termination_date',
        'payment_url',
        'post_code_id',
        'ship_post_code_id',
        'delivery_email_address1',
        'delivery_email_address2',
        'delivery_email_address3',
        'merchant_parent_store_id',
        'merchant_user_owner_id',
        'phone',
        'address',
        'token',
        'expires_at',
        'af_name',
        'af_switch',
        'af_fee',
        "auth_token",
        "hash_token",
    ];

    public function merchantUsers(): BelongsToMany
    {
        return $this->belongsToMany(MerchantUser::class, 'merchant_groups', 'merchant_store_id', 'merchant_user_id');
    }

    public function groupParentStore(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'merchant_parent_store_id', 'merchant_parent_store_id');
    }

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(Affiliate::class, "affiliate_id");
    }

    public function merchantOwner(): BelongsTo
    {
        return $this->belongsTo(MerchantUser::class, 'merchant_user_owner_id', 'id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(MerchantStore::class, Group::class, 'merchant_parent_store_id', 'merchant_children_store_id')
            ->whereNull("group_merchants.deleted_at");
    }

    public function parent(): BelongsToMany
    {
        return $this->belongsToMany(MerchantStore::class, Group::class, 'merchant_children_store_id','merchant_parent_store_id')
            ->whereNull("group_merchants.deleted_at");
    }

    public function slashApi(): HasOne
    {
        return $this->hasOne(SlashApi::class, 'merchant_store_id');
    }

    public function fiatWithdrawAccount(): HasOne
    {
        return $this->hasOne(FiatWithdrawAccount::class, 'merchant_store_id');
    }

    public function cryptoWithdrawAccount(): HasOne
    {
        return $this->hasOne(CryptoWithdrawAccount::class, 'merchant_store_id');
    }

    public function cashPayment(): HasOne
    {
        return $this->hasOne(CashPayment::class, 'merchant_store_id');
    }

    public function paymentSuccesses()
    {
        return $this->hasMany(PaymentSuccess::class, 'merchant_store_id');
    }

    public function withdraw()
    {
        return $this->hasMany(Withdraw::class, 'merchant_store_id');
    }

    public function getTotalAdjustedAmountAttribute()
    {
        $totalAdjustedAmount = 0;
        foreach ($this->withdraw as $withdraw) {
            $rate = $this->exchangeRate;
            if ($rate){
                if ($withdraw->asset === WithdrawAsset::JPY->value){
                    $totalAdjustedAmount += $withdraw->amount;
                }
                if ($withdraw->asset === WithdrawAsset::USDC->value){
                    $totalAdjustedAmount += $rate->usdc_jpy ? $withdraw->amount * $rate->usdc_jpy : 0;
                }
                if ($withdraw->asset === WithdrawAsset::USDT->value){
                    $totalAdjustedAmount += $rate->usdt_jpy ? $withdraw->amount * $rate->usdt_jpy : 0;
                }
                if ($withdraw->asset === WithdrawAsset::DAI->value){
                    $totalAdjustedAmount += $rate->dai_jpy ? $withdraw->amount * $rate->dai_jpy : 0;
                }
                if ($withdraw->asset === WithdrawAsset::JPYC->value){
                    $totalAdjustedAmount += $rate->jpyc_jpy ? $withdraw->amount * $rate->jpyc_jpy : 0;
                }
            }
        }
        return $totalAdjustedAmount;
    }

    public function exchangeRate()
    {
        return $this->hasOne(ExchangeRate::class, 'merchant_store_id');
    }

    public function postCodeId(): BelongsTo
    {
        return $this->belongsTo(Postal::class, 'post_code_id');
    }

    public function shipPostCodeId(): BelongsTo
    {
        return $this->belongsTo(Postal::class, 'ship_post_code_id');
    }
}
