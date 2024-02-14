<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum NotiFromType: string
{
    use EnumTrait;
    case FROM_USER = "from_user";
    case FROM_EPAY = "from_epay";

}
