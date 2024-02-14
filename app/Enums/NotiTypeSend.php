<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum NotiTypeSend: string
{
    use EnumTrait;
    case ALL = "0";
    case PART = "1";

}
