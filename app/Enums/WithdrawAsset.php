<?php

namespace App\Enums;

use App\Traits\EnumTrait;

/**
 * include multiple currency types of BANK(JPY), Crypto(USDT, USDC,...)
 */
enum WithdrawAsset: string
{
    use EnumTrait;

    case JPY = 'JPY';
    case JPYC = 'JPYC';
    case USDT = 'USDT';
    case USDC = 'USDC';
    case DAI = 'DAI';
}
