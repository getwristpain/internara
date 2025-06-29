<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Translator extends Helper
{
    /**
     * Translate a message with automatic resource replacement and locale support.
     *
     * @param string $key
     * @param array $replace
     * @param string $locale
     * @return string
     */
    public static function translate(string $key, array $replace = [], string $locale = 'en'): string
    {
        return __($key, static::translateReplacements($replace, $locale, $key), $locale);
    }

    /**
     * Translate replacements by detecting and converting each value
     * to its corresponding plural-domain translation.
     *
     * @param array $replacements
     * @param string $locale
     * @param string $baseKey
     * @return array
     */
    protected static function translateReplacements(array $replacements = [], string $locale = 'en', string $baseKey = ''): array
    {
        if (empty($replacements)) {
            return [];
        }

        $translatedBaseKey = __($baseKey, [], $locale);
        $prefix = ($translatedBaseKey !== $baseKey) ? explode('.', $baseKey)[0] : '';

        return collect($replacements)
            ->mapWithKeys(function ($value, $key) use ($locale, $prefix) {
                $prefix = Str::lower($prefix);
                $pluralDomain = Str::plural($key);
                $lowercase = Str::lower($value);

                $fullKey = $prefix ? "{$prefix}.{$pluralDomain}.{$lowercase}" : "{$pluralDomain}.{$value}";

                $translatedValue = __($fullKey, [], $locale);

                return [$key => $translatedValue === $fullKey ? $value : $translatedValue];
            })->all();
    }
}
