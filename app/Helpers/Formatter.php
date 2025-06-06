<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Formatter extends Helper
{
    public static function studly(string $value): string
    {
        return Str::of($value)
            ->replace([' ', '_', '-', ':'], '')
            ->studly();
    }

    public static function formatOptions(array $data): array
    {
        return collect($data)
            ->map(fn ($item) => [
                'value' => $item['id'],
                'label' => $item['name'],
            ])
            ->toArray();
    }

    public static function abbrev(string $value): string
    {
        $value = trim(preg_replace('/\s+/', ' ', $value));

        if (str_contains($value, ' ')) {
            preg_match_all('/\b([A-Z])/', $value, $matches);

            return strtoupper(implode('', $matches[1]));
        }

        preg_match_all('/\b[A-Z]|(?:(?<![aeiou])([b-df-hj-np-tv-z]))/i', ucfirst($value), $matches);

        return strtoupper(implode('', array_filter($matches[0])));
    }

    public static function snakecase(string $value): string
    {
        return Str::slug(Str::lower($value), '_');
    }
}
