<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

/**
 * ------------------------------------------------------------------------
 * Fetch Helper
 * ------------------------------------------------------------------------
 * Provides synchronous HTTP fetching with consistent error handling.
 */
class Fetch extends Helper
{
    /**
     * ------------------------------------------------------------------------
     * Sync Fetch
     * ------------------------------------------------------------------------
     * Sends a synchronous GET request and returns decoded JSON data.
     *
     * @param string $url Full URL to the target endpoint.
     * @param array<string, mixed> $query Optional query parameters.
     * @return array<string, mixed> Decoded JSON response or fallback error structure.
     */
    public static function sync(string $url, array $query = []): array
    {
        try {
            $response = Http::timeout(5)->get($url, $query);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $th) {
            Debugger::handle(
                exception: $th,
                properties: [
                    'url' => $url,
                    'query' => json_encode($query),
                ],
                throw: true
            );
        }

        return [
            'errors' => ['message' => 'Failed to fetch data from external API.']
        ];
    }
}
