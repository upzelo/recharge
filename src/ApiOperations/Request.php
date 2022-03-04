<?php

declare(strict_types=1);

namespace Recharge\ApiOperations;

use Recharge\RechargeEnum;
use Recharge\ApiRequestor;

trait Request
{
    protected static function validateParams($params = null): void
    {
        if ($params && !\is_array($params)) {
            throw new \InvalidArgumentException('Params must be an array');
        }
    }

    protected static function _staticRequest($method, $url, $params = [])
    {
        $baseUrl = RechargeEnum::DEFAULT_API_BASE->value;

        $requestor = new ApiRequestor('key', $baseUrl);

        return $requestor->request($method, $url, $params);
    }

    protected function _request($method, $url, $params = [])
    {
        $response = static::_staticRequest($method, $url, $params);
        $this->setLastResponse($response);

        return $response;
    }
}
