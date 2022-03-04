<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Product;
use Recharge\Collection;

class ProductService extends AbstractService
{
    public const OBJECT_TYPE = 'product';

    public function all(?array $params = []): Collection
    {
        return $this->requestCollection('get', 'products', $params, self::OBJECT_TYPE);
    }

    public function retrieve($id): Product
    {
        return $this->request('get', $this->buildPath('/products/%s', $id), [], self::OBJECT_TYPE);
    }
}
