<?php

declare(strict_types=1);

namespace Recharge\Contracts;

interface BaseRechargeClientInterface
{
    public function getApiKey();

    public function getClientId();

    public function getApiBase();
}
