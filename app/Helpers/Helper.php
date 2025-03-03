<?php

namespace App\Helpers;

use App\Debugger;
use Exception;
use Illuminate\Support\Str;
use ReflectionClass;

class Helper
{
    use Debugger;

    public static function key(string $key): string
    {
        return (string) (now()->timestamp.'-'.$key.'-'.Str::random(8));
    }

    /**
     * Sanitize input based on the given rules
     *
     * @param  mixed  $input  The input to be sanitized
     * @param  mixed  $rules  The sanitization rules (e.g., 'string', 'email', 'int', 'html', or an array of allowed values)
     * @return mixed The sanitized value
     */
    public static function sanitize($input, $rules)
    {
        if (is_array($input)) {
            return array_map(fn ($item) => self::sanitize($item, $rules), $input);
        }

        if (is_array($rules)) {
            return in_array($input, $rules, true) ? $input : null;
        }

        return match ($rules) {
            'string' => trim(strip_tags($input)),
            'email' => filter_var(trim($input), FILTER_SANITIZE_EMAIL),
            'url' => filter_var(trim($input), FILTER_SANITIZE_URL),
            'int' => filter_var($input, FILTER_SANITIZE_NUMBER_INT),
            'float' => filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'html' => htmlspecialchars($input, ENT_QUOTES, 'UTF-8'),
            default => throw new Exception('The given rules are not compatible.'),
        };
    }

    /**
     * Convert any value to a string representation.
     *
     * @param  mixed  $value  The value to be converted.
     * @return string The string representation of the value.
     */
    public static function stringify($value): string
    {
        return match (true) {
            is_null($value) => 'null',
            is_bool($value) => $value ? 'true' : 'false',
            is_array($value) => json_encode($value, JSON_PRETTY_PRINT),
            is_object($value) => method_exists($value, '__toString') ? (string) $value : json_encode($value, JSON_PRETTY_PRINT),
            is_string($value) => $value,
            default => throw new Exception('Value cannot be converted to the string.'),
        };
    }

    /**
     * Convert an object to an array for better readability, including private and protected properties.
     *
     * @param  object  $object  The object to be converted.
     * @return array The converted array representation.
     */
    public static function objectToArray(object $object): array
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();
        $array = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
        }

        return $array;
    }
}
