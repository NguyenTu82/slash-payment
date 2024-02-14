<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum NotiTypeReceive: string
{
    use EnumTrait;
    case NEW_REGISTER = "new_merchant";
    case WITHDRAWAL = "withdrawal";
    case CANCEL = "merchant_cancel";
    case WITHDRAWAL_ACCEPTED = "withdrawal_accepted";

}
