<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum TransactionHistoryNetwork: string
{
    use EnumTrait;

    case ETH = 'ETH';
    case BNB = 'BNB';
    case Matic = 'Matic';
    case AVAX = 'AVAX';
    case FTM = 'FTM';
    case ARBITRUM_ETH = 'ARBITRUM_ETH';
    case SOL = 'SOL';
}
