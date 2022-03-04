<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Collection;

class PlanService extends AbstractService
{
    public const OBJECT_TYPE = 'plan';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', 'plans', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id)
    {
        return $this->request('get', $this->buildPath('/plans/%s', $id), [], self::OBJECT_TYPE);
    }
}
