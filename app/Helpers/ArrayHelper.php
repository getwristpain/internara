<?php

namespace App\Helpers;

use App\Helpers\Helper;

class ArrayHelper extends Helper
{
    public static function isFlatAssoc(array $arrays): bool
    {
        foreach ($arrays as $key => $value) {
            if (is_int($key)) {
                $exception = new \InvalidArgumentException("Only flat associative arrays are allowed. Numeric key [{$key}] found.");

                Debugger::debug($exception, context: ['attributes' => $arrays]);
                return false;
            }
        }

        return true;
    }

    public static function get(array $array, string|int|array $key, mixed $default = null): mixed
    {
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

    public static function set(array &$array, string|int|array $key, mixed $value): void
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
}
