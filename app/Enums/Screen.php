<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Screen: string
{
    use EnumTrait;

    case ADMIN = "admin";
}
