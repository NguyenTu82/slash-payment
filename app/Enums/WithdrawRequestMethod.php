<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum WithdrawRequestMethod: string
{
    use EnumTrait;

    case AUTO = 'auto';
    case REQUEST_EPAY = 'request_epay';
    case REQUEST_MERCHANT = 'request_merchant';
}
