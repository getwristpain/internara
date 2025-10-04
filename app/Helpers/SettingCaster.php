<?php

namespace App\Helpers;

class SettingCaster
{
    /**
     * Casts a value to its appropriate PHP type based on the stored 'type' string.
     * This method is used when RETRIEVING the value from the database.
     *
     * @param mixed $value The raw string value from the database.
     * @param string $type The intended type (e.g., 'int', 'bool', 'json').
     * @return mixed The value cast to the specified type.
     */
    public static function cast($value, string $type): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return match (strtolower($type)) {
            'int', 'integer' => (int) $value,
            'bool', 'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'float', 'double' => (float) $value,
            'json', 'array', 'object' => json_decode($value, true),
            default => (string) $value,
        };
    }

    /**
     * Prepares the value for storage.
     * This method is used when SAVING the value to the database (always as a string).
     *
     * @param mixed $value The raw PHP value.
     * @return string The value converted to a string representation.
     */
    public static function prepareForStorage($value): string
    {
        if (is_null($value)) {
            return '';
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return (string) $value;
    }
}
