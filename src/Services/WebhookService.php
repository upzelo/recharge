<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Webhook;
use Recharge\Collection;

class WebhookService extends AbstractService
{
    public const OBJECT_TYPE = 'webhook';

    /**
     * @param array|null $params
     *
     * @return Collection<Webhook>
     */
    public function all(?array $params = null): Collection
    {
        return $this->requestCollection('get', '/webhooks', $params, self::OBJECT_TYPE);
    }

    public function create(array $params = []): Webhook
    {
        return $this->request('post', '/webhooks', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Webhook
    {
        return $this->request('get', $this->buildPath('/webhooks/%s', $id), [], self::OBJECT_TYPE);
    }

    public function delete($id): Webhook
    {
        return $this->request('delete', $this->buildPath('/discounts/%s', $id), [], self::OBJECT_TYPE);
    }
}
