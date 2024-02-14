<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum AdminRole: string
{
    use EnumTrait;

    case ADMINISTRATOR = "administrator";
    case OPERATOR = "operator";
}
