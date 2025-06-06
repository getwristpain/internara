<?php

namespace App\Helpers;

use InvalidArgumentException;

class Sanitizer extends Helper
{
    /**
     * Sanitize input value(s) based on rules and optional conditions.
     *
     * @param  string|array  $input  Input value(s) to be sanitized.
     * @param  string|array  $rules  Sanitization rule(s).
     * @param  array  $conditions  Optional conditions for filtering or validation.
     *
     * @throws InvalidArgumentException
     */
    public static function sanitize(string|int|array|null $input, string|array $rules, array $conditions = []): mixed
    {
        if ($input === null) {
            return null;
        }

        if (is_array($input)) {
            if (is_string($rules)) {
                if ($rules == 'sensitive') {
                    return static::sanitizeFromSensitive($input, $conditions);
                }

                return array_map(
                    fn ($item) => static::sanitize($item, $rules, $conditions),
                    $input
                );
            }

            return static::sanitizeArray($input, $rules, $conditions);
        }

        if (is_array($rules)) {
            throw new InvalidArgumentException('Rule array is only valid for array input.');
        }

        return static::sanitizeValue($input, $rules, $conditions);
    }

    /**
     * Sanitize an associative array based on matching rules and conditions.
     *
     * @param  array  $input  Input associative array.
     * @param  array  $rules  Array of rules for each key.
     * @param  array  $conditions  Array of conditions for each key.
     */
    protected static function sanitizeArray(array $input, array $rules, array $conditions = []): array
    {
        $sanitized = [];

        foreach ($rules as $key => $rule) {
            $value = $input[$key] ?? null;
            $conditionsValues = $conditions[$key] ?? [];

            $sanitized[$key] = static::sanitizeValue($value, $rule, $conditionsValues);
        }

        foreach ($input as $key => $value) {
            if (! array_key_exists($key, $rules)) {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize a single value with a rule and optional conditions.
     *
     * @param  mixed  $input  Input value.
     * @param  string  $rule  Sanitization rule.
     * @param  array  $conditions  Optional conditions for filtering or validation.
     *
     * @throws InvalidArgumentException
     */
    protected static function sanitizeValue(mixed $input, string $rule, array $conditions = []): mixed
    {
        $rule = Formatter::snakecase($rule);

        return match ($rule) {
            'array_bool' => is_array($input) ? array_map('filter_var', $input, array_fill(0, count($input), FILTER_VALIDATE_BOOLEAN)) : null,
            'array_float' => is_array($input) ? array_map('floatval', $input) : null,
            'array_int' => is_array($input) ? array_map('intval', $input) : null,
            'array_string' => is_array($input) ? array_map('trim', array_map('strip_tags', $input)) : null,
            'array' => is_array($input) ? array_map('trim', $input) : null,
            'bool_int' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ? 1 : 0,
            'bool_strict' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === true,
            'bool_string' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ? 'true' : 'false',
            'bool' => filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'email' => filter_var(trim((string) $input), FILTER_SANITIZE_EMAIL),
            'filter' => static::filterWithConditions($input, $conditions),
            'float' => filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
            'html' => htmlspecialchars((string) $input, ENT_QUOTES, 'UTF-8'),
            'int' => filter_var($input, FILTER_SANITIZE_NUMBER_INT),
            'message' => static::sanitizeMessage($input, $conditions),
            'sensitive' => static::sanitizeFromSensitive((array) $input, $conditions),
            'string' => trim(strip_tags((string) $input)),
            'url' => filter_var(trim((string) $input), FILTER_SANITIZE_URL),
            'query' => static::sanitizeQuery($input, $conditions),
            default => throw new InvalidArgumentException("Unsupported sanitization rule: $rule"),
        };
    }

    /**
     * Sanitize a message string by removing sensitive words and HTML tags, then trimming whitespace.
     *
     * @param  string  $message  The message to sanitize.
     * @return string The sanitized message.
     */
    protected static function sanitizeMessage(string $message, array $removedWords = []): string
    {
        $sensitiveWords = array_merge(config('filter.sensitiveKeywords', []), $removedWords);

        if (empty($sensitiveWords)) {
            return trim(strip_tags($message));
        }

        foreach ($sensitiveWords as $word) {

            $patterns = [
                '/'.$word.'\s*[:=]\s*([\'"])?[^\s,"\']+\1?/i',
                '/"'.$word.'"\s*:\s*"[^"]*"/i',
                "/'".$word."'\s*:\s*'[^']*'/i",
            ];

            foreach ($patterns as $pattern) {
                $message = preg_replace($pattern, $word.'=[removed]', $message);
            }
        }

        $pattern = '/\b('.implode('|', array_map('preg_quote', $sensitiveWords)).')\b/i';
        $message = preg_replace($pattern, '[removed]', $message);

        return trim(strip_tags($message));
    }

    /**
     * Sanitize a query string or array to prevent SQL Injection by removing sensitive keys and dangerous characters.
     *
     * @param  string|array  $query  The query string or array to sanitize.
     * @param  array  $removedWords  Additional sensitive keys to remove.
     * @return array The sanitized query as an associative array.
     */
    protected static function sanitizeQuery(string|array $query, array $removedWords = []): array
    {
        if (is_string($query)) {
            parse_str($query, $query);
        }

        $sensitiveWords = array_merge(config('filter.sensitiveKeywords', []), $removedWords);

        foreach ($sensitiveWords as $word) {
            foreach ($query as $key => $value) {
                if (stripos($key, $word) !== false) {
                    unset($query[$key]);
                }
            }
        }

        foreach ($query as $key => $value) {
            if (is_string($value)) {

                $value = preg_replace('/[\'";#`\\\]/', '', $value);
                $value = preg_replace('/(--|\b(OR|AND|SELECT|INSERT|UPDATE|DELETE|DROP|UNION|WHERE|LIKE|LIMIT|OFFSET)\b)/i', '', $value);
                $query[$key] = trim(strip_tags($value));
            }
        }

        return $query;
    }

    protected static function sanitizeFromSensitive(array $input, array $keywords): string|array|null
    {
        $conditions = [
            'keywords' => array_merge(config('filter.sensitiveKeywords', []), $keywords),
            'exclude' => true,
        ];

        return static::filterWithConditions((array) $input, $conditions);
    }

    /**
     * Filter input(s) against acceptable values.
     *
     * @param  string|array  $input  Input value(s) to be filtered.
     * @param  array  $conditions  Acceptable values.
     * @return string|array|null Filtered result or null if not acceptable.
     */
    protected static function filterWithConditions(string|array $input, array $conditions): string|array|null
    {
        if (is_array($input)) {
            return Helper::filter($input, $conditions);
        }

        return in_array($input, $conditions, true) ? $input : null;
    }
}
