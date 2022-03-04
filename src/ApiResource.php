<?php

declare(strict_types=1);

namespace Recharge;

class ApiResource extends RechargeObject
{
    public function __set($key, $value): void
    {
        parent::__set($key, $value);
    }
}
