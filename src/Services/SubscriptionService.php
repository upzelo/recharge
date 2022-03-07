<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Collection;
use Recharge\Subscription;

class SubscriptionService extends AbstractService
{
    public const OBJECT_TYPE = 'subscription';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', 'subscriptions', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Subscription
    {
        return $this->request('get', $this->buildPath('/subscriptions/%s', $id), [], self::OBJECT_TYPE);
    }

    public function cancel($id): Subscription
    {
        return $this->request('post', $this->buildPath('/subscriptions/%s/cancel', $id), [], self::OBJECT_TYPE);
    }
}
