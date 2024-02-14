<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum TransactionHistoryChainID: int
{
    use EnumTrait;

    case ETH_CHAIN_ID = 1;
    case ETH_RINKEBY_TESTNET_CHAIN_ID = 4;
    case BNB_CHAIN_ID = 56;
    case BNB_TESTNET_CHAIN_ID = 97;
    case MATIC_CHAIN_ID = 137;
    case MATIC_TESTNET_CHAIN_ID = 80001;
    case AVAX_CHAIN_ID = 43114;
    case AVAX_TESTNET_CHAIN_ID = 43113;
    case FTM_CHAIN_ID = 250;
    case FTM_TESTNET_CHAIN_ID = 4002;
    case ARBITRUM_ETH_CHAIN_ID = 42161;
    case ARBITRUM_ETH_TESTNET_CHAIN_ID = 421611;
    case SOL_CHAIN_ID = 101;
    case SOL_TESTNET_CHAIN_ID = 103;
}
