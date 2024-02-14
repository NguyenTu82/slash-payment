<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum EpayReportType: int
{
    use EnumTrait;

    // case EVERY_TRANSACTION = 0;
    case DAILY = 1;
    case WEEKLY = 2;
    case MONTHLY = 3;
    case EVERY_PAYMENT_CIRCLE = 4;
    case CUSTOM = 5;
}
