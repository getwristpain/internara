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
}
