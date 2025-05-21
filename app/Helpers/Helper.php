<?php

namespace App\Helpers;

use ReflectionClass;

abstract class Helper
{
    public function __toString(): string
    {
        return static::stringify(static::objectToArray($this));
    }

    public static function stringify(mixed $value): string
    {
        return match (gettype($value)) {
            'array' => json_encode($value, JSON_PRETTY_PRINT),
            'boolean' => $value ? 'true' : 'false',
            'integer', 'double' => (string) $value,
            'object' => method_exists($value, '__toString') ? (string) $value : json_encode($value, JSON_PRETTY_PRINT),
            'resource', 'resource (closed)' => 'resource',
            'string' => $value,
            'NULL' => 'NULL',
            default => 'unknown',
        };
    }

    public static function objectToArray(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $array = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $array[$property->getName()] = $property->getValue($object);
        }

        $methods = [];
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if (
                $method->class === $reflection->getName() &&
                ! $method->isConstructor() &&
                ! $method->isDestructor() &&
                strpos($method->getName(), '__') !== 0
            ) {
                $methods[] = $method->getName();
            }
        }
        if ($methods) {
            $array['methods'] = $methods;
        }

        return $array;
    }

    public static function isAssoc(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    public static function hasNestedArray(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }

        return false;
    }

    public static function getKeysWithKeywords(array $array, array $keywords): array
    {
        return array_filter(array_keys($array), function ($key) use ($keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($key, $keyword) !== false) {
                    return true;
                }
            }

            return false;
        });
    }

    public static function filter(array $items, array|callable|null $conditions = null): array
    {
        if (is_null($conditions)) {
            return array_filter($items, fn ($item) => !empty($item));
        }

        if (is_callable($conditions)) {
            return array_filter($items, $conditions, ARRAY_FILTER_USE_BOTH);
        }

        if (is_array($conditions) && ! empty($conditions['keywords'])) {
            $exclude = ! empty($conditions['exclude']);
            $keywords = static::getKeysWithKeywords($items, (array) $conditions['keywords']);

            if ($exclude) {
                return array_filter($items, fn ($v, $k) => ! in_array($k, $keywords), ARRAY_FILTER_USE_BOTH);
            } else {
                return array_filter($items, fn ($v, $k) => in_array($k, $keywords), ARRAY_FILTER_USE_BOTH);
            }
        }

        if (is_array($conditions) && static::isAssoc($conditions)) {
            return array_filter($items, function ($item) use ($conditions) {
                foreach ($conditions as $key => $value) {
                    if (is_array($item)) {
                        if (! array_key_exists($key, $item) || $item[$key] != $value) {
                            return false;
                        }
                    } elseif (is_object($item)) {
                        if (! isset($item->{$key}) || $item->{$key} != $value) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }

                return true;
            });
        }

        if (is_array($conditions) && ! static::isAssoc($conditions)) {
            $keys = array_filter($conditions, fn ($key) => is_string($key) || is_numeric($key));

            if (! static::isAssoc($items)) {
                return array_intersect($items, $conditions);
            }

            return array_intersect_key($items, array_flip($keys));
        }

        return $items;
    }
}
