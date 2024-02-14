<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EpayReceiveNoti.
 *
 * @package namespace App\Models;
 */
class EpayReceiveNoti extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasUuid;

    protected $table = 'epay_receive_notification';

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant_id',
        'format_type_id',
        'send_date',
        'title',
        'content',
        'type',
        'status',
    ];
}
