<?php

declare(strict_types=1);

namespace Recharge;

use Recharge\Helpers\Set;
use ReturnTypeWillChange;
use Recharge\Helpers\Util;

use function substr;
use function is_array;
use function array_map;
use function is_object;
use function array_keys;
use function array_reduce;
use function method_exists;

class RechargeObject implements \ArrayAccess, \Countable, \JsonSerializable
{
    protected array $values = [];

    protected array $originalValues = [];

    protected Set $transientValues;

    protected Set $unsavedValues;

    protected ?ApiResponse $lastResponse = null;

    public function __construct($id = null)
    {
        if (null !== $id) {
            $this->values['id'] = $id;
        }

        $this->transientValues = new Set();
        $this->unsavedValues = new Set();
    }

    public static function constructFrom($values)
    {
        $object = new static($values['id'] ?? null);

        $object->refreshFrom($values);

        return $object;
    }

    public static function deepCopy($object)
    {
        if (is_array($object)) {
            $copy = [];
            foreach ($object as $key => $value) {
                $copy[$key] = static::deepCopy($value);
            }

            return $copy;
        }

        if ($object instanceof RechargeObject) {
            return $object::constructFrom(
                self::deepCopy($object->values),
            );
        }

        return $object;
    }

    public function toArray(): array
    {
        $maybeToArray = function ($value) {
            if (null === $value) {
                return null;
            }

            return is_object($value) && method_exists($value, 'toArray') ? $value->toArray() : $value;
        };

        return array_reduce(array_keys($this->values), function ($acc, $k) use ($maybeToArray) {
            if ('_' === substr((string) $k, 0, 1)) {
                return $acc;
            }
            $v = $this->values[$k];
            if (Util::isList($v)) {
                $acc[$k] = array_map($maybeToArray, $v);
            } else {
                $acc[$k] = $maybeToArray($v);
            }

            return $acc;
        }, []);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function refreshFrom($values, $partial = false): void
    {
        $this->originalValues = self::deepCopy($values);

        if ($values instanceof RechargeObject) {
            $values = $values->toArray();
        }

        $removed = $partial ?
            new Set() :
            new Set(array_diff(array_keys($this->values), array_keys($values)));

        foreach ($removed->toArray() as $k) {
            unset($this->{$k});
        }

        $this->updateAttributes($values, false);

        foreach ($values as $k => $v) {
            $this->transientValues->discard($k);
            $this->unsavedValues->discard($k);
        }
    }

    public function updateAttributes($values, bool $dirty = true): void
    {
        foreach ($values as $key => $value) {
            if (('metadata' === $key) && (\is_array($value))) {
                $this->values[$key] = self::constructFrom($value);
            } else {
                $this->values[$key] = Util::convertToRechargeObject($value);
            }

            if ($dirty) {
                $this->dirtyValue($this->values[$key]);
            }

            $this->unsavedValues->add($key);
        }
    }

    public function dirty(): void
    {
        $this->unsavedValues = new Set(array_keys($this->values));
        foreach ($this->values as $key => $value) {
            $this->dirtyValue($value);
        }
    }

    public function dirtyValue($value): void
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                $this->dirtyValue($v);
            }
        } elseif (is_object($value)) {
            if ($value instanceof RechargeObject) {
                $value->dirty();
            }
        }
    }

    public function &__get($key)
    {
        $nullVal = null;

        if (!empty($this->values) && array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }

        return $nullVal;
    }

    public function __set($key, $value)
    {
        $this->values[$key] = Util::convertToRechargeObject($value);
        $this->dirtyValue($this->values[$key]);
        $this->unsavedValues->add($key);
    }

    public function __debugInfo()
    {
        return $this->values;
    }

    #[ReturnTypeWillChange]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    #[ReturnTypeWillChange]
    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->values);
    }

    #[ReturnTypeWillChange]
    public function offsetUnset(mixed $offset): void
    {
        unset($this->values[$offset]);
    }

    #[ReturnTypeWillChange]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->values[$offset] ?? null;
    }

    #[ReturnTypeWillChange]
    public function count(): int
    {
        return \count($this->values);
    }

    #[ReturnTypeWillChange]
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        $class = static::class;

        return $class . ' JSON: ' . $this->toJson();
    }

    public function setLastResponse(?ApiResponse $response): void
    {
        $this->lastResponse = $response;
    }
}
