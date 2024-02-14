<?php

namespace App\Enums;

enum MerchantStoreStatus: int
{
    case TEMPORARILY_REGISTERED = 1; // 仮登録済
    case UNDER_REVIEW = 2; // 審査中
    case IN_USE = 3; // 利用中
    case SUSPEND = 4; // 停止中
    case WITHDRAWAL = 5; // 退会
    case FORCED_WITHDRAWAL = 6; // 強制退会
    case AGREEMENT = 7; // 契約
    case CANCEL = 8; // 削除済
}
