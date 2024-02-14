<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum NotiStatusReceive: string
{
    use EnumTrait;

    case UNREAD = "0"; //未読

    case ALREADY_READ = "1"; //既読
}
