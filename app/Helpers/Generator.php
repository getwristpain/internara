<?php

namespace App\Helpers;

use Illuminate\Support\Str;

/**
 * Generator helper for creating unique keys.
 */
class Generator extends Helper
{
    /**
     * Generate a unique key.
     *
     * @param string|int $unique If integer, sets the key length (default 32).
     * @param bool $timestamp If true, prepends the timestamp to the key.
     * @return string
     */
    public static function key(string|int|null $unique = null, bool $timestamp = false): string
    {
        $length = 32;
        $identifier = '';

        if (is_int($unique) && $unique > 0) {
            $length = $unique;
            $identifier = Str::random($length);
        } else {
            $identifier = empty($unique) ? Str::random(8) : $unique;
        }

        $datetime = now()->format('Ymd-Hi');
        $rawKey = implode('-', array_values(array_filter([$datetime, $identifier, Str::random(8)])));

        $hash = $length > 32
            ? hash('sha256', $rawKey)
            : md5($rawKey);

        $finalKey = substr($hash, 0, $length);

        return $timestamp
            ? implode('-', [$datetime, $finalKey])
            : $finalKey;
    }
}
