<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use TransformableTrait;
    use SoftDeletes;
    protected $table = 'group_merchants';
    protected $keyType = "string";
    protected $fillable = [
        'merchant_parent_store_id',
        'merchant_children_store_id'
    ];

    public function parentStore(): HasOne
    {
        return $this->hasOne(MerchantStore::class, 'id', 'merchant_parent_store_id');
    }

    public function childrenStore(): HasMany
    {
        return $this->hasMany(MerchantStore::class, 'merchant_parent_store_id', 'merchant_parent_store_id');
    }
}
