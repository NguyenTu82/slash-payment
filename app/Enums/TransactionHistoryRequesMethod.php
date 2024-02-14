<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum TransactionHistoryRequesMethod: string
{
    use EnumTrait;
    
    case END = "from_user";
    case MERCHANT = "from_merchant";
}
