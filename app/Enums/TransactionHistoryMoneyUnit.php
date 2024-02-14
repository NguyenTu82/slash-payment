<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum TransactionHistoryMoneyUnit: string
{
    use EnumTrait;

    case USD = 'USD';
    case JPY = 'JPY';
    case EUR = 'EUR';
    case AED = 'AED';
    case SGD = 'SGD';
    case HKD = 'HKD';
    case CAD = 'CAD';
    case IDR = 'IDR';
    case PHP = 'PHP';
    case INR = 'INR';
    case KRW = 'KRW';
}
