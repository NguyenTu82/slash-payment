<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum EpayReportStatus: int
{
    use EnumTrait;

    case UNSEND = 0;
    case SENT = 1;
}
