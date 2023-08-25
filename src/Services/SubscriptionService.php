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

    public function cancel($id, $params = []): Subscription
    {
        return $this->request('post', $this->buildPath('/subscriptions/%s/cancel', $id), $params, self::OBJECT_TYPE);
    }

    /*https://developer.rechargepayments.com/2021-11/subscriptions/subscriptions_activate*/
    public function activate($id, $params = []): Subscription
    {
        return $this->request('post', $this->buildPath('/subscriptions/%s/activate', $id), $params, self::OBJECT_TYPE);
    }

    /*https://developer.rechargepayments.com/2021-01/subscriptions/subscriptions_change_next_charge*/
    public function reschedule($id, $params = []): Subscription
    {
        return $this->request('post', $this->buildPath('/subscriptions/%s/set_next_charge_date', $id), $params, self::OBJECT_TYPE);
    }
}
