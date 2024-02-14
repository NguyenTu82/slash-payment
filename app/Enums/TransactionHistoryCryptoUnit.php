<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum TransactionHistoryCryptoUnit: string
{
    use EnumTrait;

    case USDT = 'USDT';
    case USDC = 'USDC';
    case DAI = 'DAI';
    case JPYC = 'JPYC';
}
