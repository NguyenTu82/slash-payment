<?php

namespace App\Enums;

enum MerchantRole: string
{
    case ADMINISTRATOR = 'administrator';
    case OPERATOR = 'operator';
    case USER = 'user';
}
