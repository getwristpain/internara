<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Fetch extends Helper
{
    public static function sync(string $url, array $filter = []): array
    {
        try {
            $response = Http::timeout(5)->get($url, $filter);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $th) {
            Debugger::handle($th, "API request failed for url: {$url}", ['url' => $url, 'filter' => json_encode($filter)], throw: true);
        }

        return ['errors' => ['Failed to fetch data']];
    }
}
