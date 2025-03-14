<?php

namespace App\Helpers;

use App\Helpers\Helper;

class Formatter extends Helper
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        //
    }

    public static function formatOptions(array $data): array
    {
        return collect($data)
            ->map(fn($item) => [
                'value' => $item['id'],
                'label' => $item['name'],
            ])
            ->toArray();
    }

    public static function abbrev(string $value): string
    {
        // Hilangkan spasi berlebih dan pastikan format bersih
        $value = trim(preg_replace('/\s+/', ' ', $value));

        // Jika ada lebih dari satu kata, ambil huruf pertama dari setiap kata
        if (str_contains($value, ' ')) {
            preg_match_all('/\b([A-Z])/', $value, $matches);
            return strtoupper(implode('', $matches[1]));
        }

        // Jika hanya satu kata, ambil huruf pertama dari setiap suku kata utama
        preg_match_all('/\b[A-Z]|(?:(?<![aeiou])([b-df-hj-np-tv-z]))/i', ucfirst($value), $matches);
        return strtoupper(implode('', array_filter($matches[0])));
    }
}
