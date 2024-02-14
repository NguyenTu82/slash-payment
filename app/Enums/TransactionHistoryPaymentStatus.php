<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum TransactionHistoryPaymentStatus: string
{
    use EnumTrait;
    
    case OUTSTANDING = "requested";
    case SUCCESS = "success";
    case FAIL = "cancelled";
}
