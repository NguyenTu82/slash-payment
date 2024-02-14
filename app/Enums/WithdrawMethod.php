<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum WithdrawMethod: string
{
    use EnumTrait;

    case CASH = 'cash';
    case BANKING = 'banking';
    case CRYPTO = 'crypto';

}
