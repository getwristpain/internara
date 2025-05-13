<?php

namespace App\Helpers;

use App\Debugger;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ReflectionClass;
use Throwable;

abstract class Helper
{
    use Debugger;

    public static function debugger(string $level, string $message, string|array|Throwable $context = []): string
    {
        return app(self::class)->debug($level, $message, $context);
    }

    public static function logger(string|array $messages, array $context = [], Model|string|int|null $causedBy = null)
    {
        return app(self::class)->log($messages, $context, $causedBy);
    }

    public static function key(string $identifier): string
    {
        $items = [$identifier, now()->timestamp, Str::random(8)];
        $filteredItems = self::array_filter($items);

        return (string) implode('-', $filteredItems);
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

    public static function array_filter(...$items): array
    {
        return array_filter(array_merge(...$items), fn ($item) => ! empty($item));
    }
}
