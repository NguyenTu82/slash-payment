<?php

namespace App\Enums;

enum MerchantStorePaymentCycle: int
{
    case THREE_DAYS_END = 0;
    case WEEKEND = 1;
    case MONTH_END = 2;
}
