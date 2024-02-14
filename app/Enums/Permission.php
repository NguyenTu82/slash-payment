<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Permission: string
{
    use EnumTrait;

    case CREATE = "create";
    case READ = "read";
    case UPDATE = "update";
    case DELETE = "delete";
}
