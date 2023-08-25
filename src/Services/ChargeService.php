<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Charge;

class ChargeService extends AbstractService
{
    public const OBJECT_TYPE = 'charge';

    public function all(?array $params = null)
    {
        return $this->requestCollection('get', '/charges', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Charge
    {
        return $this->request('get', $this->buildPath('/charges/%s', $id), [], self::OBJECT_TYPE);
    }

    public function skip($id, $subscriptionIds): Charge
    {
        return $this->request(
            'post',
            $this->buildPath('/charges/%s/skip', $id),
            ['subscription_ids' => $subscriptionIds],
            self::OBJECT_TYPE
        );
    }

    public function unSkip($id, $subscriptionIds): Charge
    {
        return $this->request(
            'post',
            $this->buildPath('/charges/%s/unskip', $id),
            ['subscription_ids' => $subscriptionIds],
            self::OBJECT_TYPE
        );
    }
}
