<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum MerchantUserStatus: string
{
    use EnumTrait;

    case VALID = "1";

    case INVALID = "0";
}
