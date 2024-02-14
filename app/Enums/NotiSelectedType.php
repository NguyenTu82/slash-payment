<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum NotiSelectedType: string
{
    use EnumTrait;

    case SEND = "1";

    case RECEIVE = "0";
}
