<?php

declare(strict_types=1);

namespace Recharge\Contracts;

interface RechargeClientInterface extends BaseRechargeClientInterface
{
    public function request($method, $path, $params, string $objectType, bool $isList = false);
}
