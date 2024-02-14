<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum CryptoNetwork: string
{
    use EnumTrait;
    case ETHEREUM = 'Ethereum (ETH)';
    case BNB_CHAIN = 'BNB Chain (BNB)';
    case POLYGON = 'Polygon (Matic)';
    case CCCHAIN = 'Avalanche C-Cchain (AVAX)';
    case FANTOM = 'Fantom (FTM)';
    case ARBITRUM_ONE = 'Arbitrum One (ETH)';
    case SOLANA = 'Solana (SOL)';
}
