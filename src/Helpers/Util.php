<?php

declare(strict_types=1);

namespace Recharge\Helpers;

use Recharge\RechargeObject;

abstract class Util
{
    public static function encodeParameters($parameters): string
    {
        $flattenedParameters = self::flattenParameters($parameters);
        $pieces = [];
        foreach ($flattenedParameters as $parameter) {
            [$key, $value] = $parameter;
            $pieces[] = urlencode($key) . '=' . urlencode($value);
        }

        return implode('&', $pieces);
    }

    public static function flattenParameters($parameters, ?string $parentKey = null): array
    {
        $result = [];

        foreach ($parameters as $key => $value) {
            $calculatedKey = $parentKey ? "{$parentKey}[{$key}]" : $key;

            if (self::isList($value)) {
                $result = array_merge($result, self::flattenParamsList($value, $calculatedKey));
            } elseif (is_array($value)) {
                $result = array_merge($result, self::flattenParams($value, $calculatedKey));
            } else {
                array_push($result, [$calculatedKey, $value]);
            }
        }

        return $result;
    }

    public static function isList(mixed $array): bool
    {
        if (!is_array($array)) {
            return false;
        }

        if ([] === $array) {
            return true;
        }

        // if (($array['object'] ?? null) === 'list') {
        //     return true;
        // }

        if (array_keys($array) !== range(0, count($array) - 1)) {
            return false;
        }

        return true;
    }

    public static function flattenParamsList($value, $calculatedKey): array
    {
        $result = [];

        foreach ($value as $i => $elem) {
            if (self::isList($elem)) {
                $result = array_merge($result, self::flattenParamsList($elem, $calculatedKey));
            } elseif (is_array($elem)) {
                $result = array_merge($result, self::flattenParams($elem, "{$calculatedKey}[{$i}]"));
            } else {
                array_push($result, ["{$calculatedKey}[{$i}]", $elem]);
            }
        }

        return $result;
    }

    public static function flattenParams($params, $parentKey = null): array
    {
        $result = [];

        foreach ($params as $key => $value) {
            $calculatedKey = $parentKey ? "{$parentKey}[{$key}]" : $key;

            if (self::isList($value)) {
                $result = array_merge($result, self::flattenParamsList($value, $calculatedKey));
            } elseif (is_array($value)) {
                $result = array_merge($result, self::flattenParams($value, $calculatedKey));
            } else {
                array_push($result, [$calculatedKey, $value]);
            }
        }

        return $result;
    }

    public static function objectsToIds(mixed $h): mixed
    {
        if (static::isList($h)) {
            $results = [];
            foreach ($h as $v) {
                $results[] = static::objectsToIds($v);
            }

            return $results;
        }
        if (\is_array($h)) {
            $results = [];
            foreach ($h as $k => $v) {
                if (null === $v) {
                    continue;
                }
                $results[$k] = static::objectsToIds($v);
            }

            return $results;
        }

        return $h;
    }

    public static function convertToRechargeObject($resp)
    {
        $types = ObjectTypes::MAPPING;
        if (self::isList($resp)) {
            $mapped = [];
            foreach ($resp as $i) {
                $mapped[] = self::convertToRechargeObject($i);
            }

            return $mapped;
        }
        if (\is_array($resp)) {
            $class = $types[$resp['object'] ?? null] ?? RechargeObject::class;
            return $class::constructFrom($resp);
        }

        return $resp;
    }
}
