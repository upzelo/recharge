<?php

declare(strict_types=1);

namespace Recharge;

enum RechargeEnum: string
{
    case DEFAULT_API_BASE = 'https://api.rechargeapps.com';
    case DEFAULT_API_VERSION = '2021-11';
}
