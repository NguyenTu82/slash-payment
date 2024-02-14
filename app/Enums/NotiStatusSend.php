<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum NotiStatusSend: string
{
    use EnumTrait;

    case UNSEND = "0";

    case SEND = "1";
}
