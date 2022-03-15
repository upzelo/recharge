<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Shop;

class ShopService extends AbstractService
{
    public const OBJECT_TYPE = 'shop';

    public function retrieve($params = []): Shop
    {
        return $this->request('get', 'shop', $params, self::OBJECT_TYPE);
    }
}
