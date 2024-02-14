<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum WithdrawStatus: string
{
    use EnumTrait;

    case WAITING_APPROVE = 'waiting_approve';//承認待ち
    case DENIED = 'denied';  //失敗・拒否
    case SUCCEEDED = 'succeeded'; //完了
    case CANCELLED = 'cancelled'; //取消
}
