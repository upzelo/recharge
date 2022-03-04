<?php

declare(strict_types=1);

namespace Recharge\Helpers;

use ArrayIterator;
use IteratorAggregate;

class Set implements IteratorAggregate
{
    private array $values;

    public function __construct(array $members = [])
    {
        $this->values = [];
        foreach ($members as $item) {
            $this->values[$item] = true;
        }
    }

    public function includes($key): bool
    {
        return isset($this->values[$key]);
    }

    public function add($key): void
    {
        $this->values[$key] = true;
    }

    public function discard($key): void
    {
        unset($this->values[$key]);
    }

    public function toArray(): array
    {
        return array_keys($this->values);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

}
