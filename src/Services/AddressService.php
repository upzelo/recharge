<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Address\Address;

class AddressService extends AbstractService
{
    public const OBJECT_NAME = 'address';

    public function retrieve($id): Address
    {
        return $this->request('get', $this->buildPath('/addresses/%s', $id), [], self::OBJECT_NAME);
    }

    public function update($id, array $params = []): Address
    {
        return $this->request('put', $this->buildPath('/addresses/%s', $id), $params, self::OBJECT_NAME);
    }
}
