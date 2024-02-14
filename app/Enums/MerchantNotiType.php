<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum MerchantNotiType: string
{
    use EnumTrait;

    case WITHDRAW = "0";

    case OTHER = "1";
}
