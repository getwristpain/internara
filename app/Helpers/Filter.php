<?php

namespace App\Helpers;

class Filter
{
    /**
     * Filters an array to include only the specified keys, and removes null values.
     *
     * @param array $attributes The array to filter.
     * @param string|array<string> $include The keys to include.
     *
     * @return array
     */
    public static function only(array $attributes, string|array $include = []): array
    {
        return collect($attributes)
            ->only($include)
            ->filter()
            ->toArray();
    }
}
