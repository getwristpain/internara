<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Support class provides static utility methods for string, array, and object transformation.
 */
class Support extends Helper
{
    /**
     * Convert any value to string.
     *
     * @param mixed $value
     * @return string
     */
    public static function stringify(mixed $value): string
    {
        return match (gettype($value)) {
            'array' => json_encode($value, JSON_PRETTY_PRINT),
            'boolean' => $value ? 'true' : 'false',
            'integer', 'double' => (string) $value,
            'object' => method_exists($value, '__toString')
                ? (string) $value
                : json_encode($value, JSON_PRETTY_PRINT),
            'resource', 'resource (closed)' => 'resource',
            'string' => $value,
            'NULL' => 'NULL',
            default => 'unknown',
        };
    }

    /**
     * Check if array contains nested arrays.
     *
     * @param array $array
     * @return bool
     */
    public static function hasNestedArray(array $array): bool
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if array is a flat associative array (no numeric keys).
     *
     * @param array $array
     * @return bool
     */
    public static function isFlatAssocArray(array $array): bool
    {
        foreach ($array as $key => $value) {
            if (is_int($key)) {
                Debugger::handle(
                    new \InvalidArgumentException("Only flat associative arrays are allowed. Numeric key [{$key}] found."),
                    'Failed to validate flat associative array',
                    ['attributes' => $array]
                );
                return false;
            }
        }
        return true;
    }

    /**
     * Get value from nested array using key or path.
     *
     * @param array $array
     * @param string|int|array $key
     * @param mixed $default
     * @return mixed
     */
    public static function getArray(array $array, string|int|array $key = '', mixed $default = null): mixed
    {
        if (empty($key)) {
            return !empty($array) ? $array : $default;
        }
        if (is_array($key)) {
            foreach ($key as $k) {
                $array = $array[$k] ?? $default;
                if ($array === $default) {
                    break;
                }
            }
            return $array;
        }
        return $array[$key] ?? $default;
    }

    /**
     * Set nested value into array using path.
     *
     * @param array $array
     * @param string|int|array $key
     * @param mixed $value
     * @return void
     */
    public static function setArray(array &$array, string|int|array $key, mixed $value): void
    {
        if (is_array($key)) {
            $ref = &$array;
            foreach ($key as $k) {
                if (!isset($ref[$k]) || !is_array($ref[$k])) {
                    $ref[$k] = [];
                }
                $ref = &$ref[$k];
            }
            $ref = $value;
        } else {
            $array[$key] = $value;
        }
    }

    /**
     * Get array keys matching keywords.
     *
     * @param array $array
     * @param array $keywords
     * @return array
     */
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

    /**
     * Filter array with callable, keyword, or conditions.
     *
     * @param array $items
     * @param array|callable|null $conditions
     * @return array
     */
    public static function filter(array $items, array|callable|null $conditions = null): array
    {
        if (is_null($conditions)) {
            return array_filter($items, fn ($item) => !empty($item));
        }
        if (is_callable($conditions)) {
            return array_filter($items, $conditions, ARRAY_FILTER_USE_BOTH);
        }
        if (is_array($conditions)) {
            if (!empty($conditions['keywords'])) {
                $keywords = static::getKeysWithKeywords($items, (array) $conditions['keywords']);
                $exclude = !empty($conditions['exclude']);
                return array_filter(
                    $items,
                    fn ($v, $k) => $exclude ? !in_array($k, $keywords) : in_array($k, $keywords),
                    ARRAY_FILTER_USE_BOTH
                );
            }
            if (Arr::isAssoc($conditions)) {
                return array_filter($items, function ($item) use ($conditions) {
                    foreach ($conditions as $key => $value) {
                        if (is_array($item)) {
                            if (!array_key_exists($key, $item) || $item[$key] != $value) {
                                return false;
                            }
                        } elseif (is_object($item)) {
                            if (!isset($item->{$key}) || $item->{$key} != $value) {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                    return true;
                });
            }
            $keys = array_filter($conditions, fn ($k) => is_string($k) || is_numeric($k));
            return Arr::isAssoc($items)
                ? array_intersect_key($items, array_flip($keys))
                : array_intersect($items, $conditions);
        }
        return $items;
    }

    /**
     * Convert public properties and method names to array.
     *
     * @param object $object
     * @return array
     */
    public static function objectToArray(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $data = [];
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $prop) {
            $name = $prop->getName();
            try {
                $data[$name] = $prop->isInitialized($object) ? $prop->getValue($object) : null;
            } catch (\Throwable $e) {
                $data[$name] = null;
            }
        }
        $methods = array_filter(
            array_map(fn (ReflectionMethod $m) => $m->getName(), $reflection->getMethods(ReflectionMethod::IS_PUBLIC)),
            fn ($name) => !str_starts_with($name, '__')
        );
        if (!empty($methods)) {
            $data['methods'] = array_values($methods);
        }
        return $data;
    }
}
