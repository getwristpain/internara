<?php

namespace App\Helpers;

use InvalidArgumentException;

class Sanitizer extends Helper
{
    /**
     * Sanitize input value(s) with given rule(s)
     *
     * @param  string|array  $input  Input value or associative array of values
     * @param  string|array  $rules  Rule string or associative array of rules
     * @param  array  $acceptable  Acceptable values for 'acceptabled' rule, optionally keyed by field
     * @return mixed Sanitized result
     */
    public static function sanitize(string|array $input, string|array $rules, array $acceptable = []): mixed
    {
        if (is_array($input)) {
            if (is_string($rules)) {
                // Single rule applied to all array values
                return array_map(
                    fn ($item) => self::sanitize($item, $rules, $acceptable),
                    $input
                );
            }

            // Match rule set with each input key
            return self::sanitizeArray($input, $rules, $acceptable);
        }

        if (is_array($rules)) {
            throw new InvalidArgumentException('Rule array is only valid for array input.');
        }

        return self::sanitizeValue($input, $rules, $acceptable);
    }

    /**
     * Sanitize an associative array based on matching rules
     */
    protected static function sanitizeArray(array $input, array $rules, array $acceptable = []): array
    {
        $sanitized = [];

        // Sanitize values defined in the rules
        foreach ($rules as $key => $rule) {
            $value = $input[$key] ?? null;
            $acceptableValues = $acceptable[$key] ?? [];

            $sanitized[$key] = self::sanitizeValue($value, $rule, $acceptableValues);
        }

        // Add any extra input values not defined in the rules
        foreach ($input as $key => $value) {
            if (! array_key_exists($key, $rules)) {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize a single value with a rule
     */
    protected static function sanitizeValue(mixed $input, string $rule, array $acceptable = []): mixed
    {
        return match ($rule) {
            'acceptabled' => self::filterAcceptable($input, $acceptable),
            'array' => is_array($input) ? array_map('trim', $input) : null,
            'array_string' => is_array($input) ? array_map('trim', array_map('strip_tags', $input)) : null,
            'array_int' => is_array($input) ? array_map('intval', $input) : null,
            'array_float' => is_array($input) ? array_map('floatval', $input) : null,
            'array_bool' => is_array($input) ? array_map('filter_var', $input, array_fill(0, count($input), FILTER_VALIDATE_BOOLEAN)) : null,
            'bool' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'bool_strict' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === true,
            'bool_int' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ? 1 : 0,
            'bool_string' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ? 'true' : 'false',
            'string' => trim(strip_tags((string) $input)),
            'email' => filter_var(trim((string) $input), FILTER_SANITIZE_EMAIL),
            'url' => filter_var(trim((string) $input), FILTER_SANITIZE_URL),
            'int' => filter_var($input, FILTER_SANITIZE_NUMBER_INT),
            'float' => filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'html' => htmlspecialchars((string) $input, ENT_QUOTES, 'UTF-8'),
            default => throw new InvalidArgumentException("Unsupported sanitization rule: $rule"),
        };
    }

    /**
     * Filter input(s) against acceptable values
     *
     * @param  string|array  $input  Input value(s) to be filtered
     * @param  array  $acceptable  Acceptable values
     * @return string|array|null Filtered result or null if not acceptable
     */
    private static function filterAcceptable(string|array $input, array $acceptable): string|array|null
    {
        if (is_array($input)) {
            return array_values(array_filter(
                $input,
                fn ($item) => in_array($item, $acceptable, true)
            ));
        }

        return in_array($input, $acceptable, true) ? $input : null;
    }
}
