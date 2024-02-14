<?php

namespace App\Enums;

enum MerchantStoreShipDate: int
{
    case END_MONTH = 0;
    case EVERY_WEEKEND = 1;
    case END_OTHER_WEEKEND = 2;
}
