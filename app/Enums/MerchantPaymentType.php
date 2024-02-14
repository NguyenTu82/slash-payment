<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum MerchantPaymentType: string
{
    use EnumTrait;
    case CASH = 'cash';
    case FIAT = 'banking';
    case CRYPTO = 'crypto';
}
