<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Discount;
use Recharge\Collection;

class DiscountService extends AbstractService
{
    public const OBJECT_TYPE = 'discount';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', 'discounts', $params, self::OBJECT_TYPE);
    }

    public function create(?array $params = []): Discount
    {
        return $this->request('post', 'discounts', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Discount
    {
        return $this->request('get', $this->buildPath('/discounts/%s', $id), [], self::OBJECT_TYPE);
    }

    public function delete($id): Discount
    {
        return $this->request('delete', $this->buildPath('/discounts/%s', $id), [], self::OBJECT_TYPE);
    }

    public function update($id, array $params = []): Discount
    {
        return $this->request('put', $this->buildPath('/discounts/%s', $id), $params, self::OBJECT_TYPE);
    }
}
