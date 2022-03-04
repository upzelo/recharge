<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Discount;
use Recharge\Collection;

class SubscriptionService extends AbstractService
{
    public const OBJECT_TYPE = 'subscription';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', 'subscriptions', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Discount
    {
        return $this->request('get', $this->buildPath('/subscriptions/%s', $id), [], self::OBJECT_TYPE);
    }
}
