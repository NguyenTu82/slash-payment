<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum FiatAccountType: string
{
    use EnumTrait;
    // 口座種別(0: 普通, 1: 定期, 2:当座)
    case ORDINARY = '0';
    case TERM_DEPOSIT = '1';
    case CURRENT = '2';
}
