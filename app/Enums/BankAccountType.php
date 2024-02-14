<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum BankAccountType: int
{
    use EnumTrait;

    case USUALLY = 1;
    case REGULAR = 2;
    case CURRENT = 3;
}
