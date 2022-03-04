<?php

declare(strict_types=1);

namespace Recharge;

use Traversable;
use Recharge\ApiOperations\Request;

/**
 * @template TRechargeObject of RechargeObject
 * @template-implements \IteratorAggregate<TRechargeObject>
 *
 * @property bool              $has_more
 * @property ?string           $next_cursor
 * @property ?string           $previous_cursor
 * @property TRechargeObject[] $data
 */
class Collection extends RechargeObject implements \Countable, \IteratorAggregate
{
    use Request;
    public const OBJECT_NAME = 'list';

    public array $data = [];
    protected array $filters = [];

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public static function emptyCollection(): Collection
    {
        return Collection::constructFrom(['data' => []]);
    }

    // public function autoPagingIterator()
    // {
    //     $page = $this;
    //
    //     while (true) {
    //         $filters = $this->filters ?? [];
    //     }
    // }

    public function setFilters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function all($params = null)
    {
        self::validateParams($params);
    }

    public function nextPage(?array $params = null)
    {
        if ($this->has_more) {
            return static::emptyCollection();
        }

        $lastId = end($this->data)->id;

        $params = array_merge(
            $this->filters ?? [],
            ['cursor' => $this->next_cursor],
            $params ?? [],
        );

        return $this->all();
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->data);
    }
}
