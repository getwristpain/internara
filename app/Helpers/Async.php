<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Async extends Helper
{
    private static function generateCacheKey(string $cacheKey, array $filter = []): string
    {
        return ! empty($filter)
            ? "api_cache_{$cacheKey}_".md5(json_encode($filter))
            : "api_cache_{$cacheKey}";
    }

    private static function getCacheFilename(string $cacheKey): string
    {
        return "cache/data/{$cacheKey}.json";
    }

    protected static function fetchFromApi(string $cacheKey, string $filename, string $url, array $filter, int $ttl): array
    {
        try {
            $response = Http::timeout(5)->get($url, $filter);

            if ($response->successful()) {
                $data = $response->json();
                self::storeData($cacheKey, $filename, $data, $ttl);

                return $data;
            }
        } catch (Throwable $th) {
            self::debugger('error', "API request failed for {$cacheKey}", $th);
            throw $th;
        }

        return ['error' => 'Failed to fetch data'];
    }

    protected static function storeData(string $cacheKey, string $filename, array $data, int $ttl): void
    {
        try {
            Cache::put($cacheKey, $data, $ttl);

            if (count($data) > 1000) {
                dispatch(fn () => Storage::put($filename, json_encode($data, JSON_PRETTY_PRINT)))
                    ->delay(now()->addSeconds(1));
            }
        } catch (Throwable $th) {
            self::debugger('error', 'Failed to store data in cache or storage', $th);
            throw $th;
        }
    }

    public static function fetch(string $cacheKey, string $url, int $ttl = 3600, array $filter = []): array
    {
        $cacheKey = self::generateCacheKey($cacheKey, $filter);
        $filename = self::getCacheFilename($cacheKey);

        return Cache::remember($cacheKey, $ttl, function () use ($cacheKey, $filename, $url, $filter, $ttl) {
            return self::fetchFromApi($cacheKey, $filename, $url, $filter, $ttl);
        });
    }

    public static function forget(string $cacheKey, array $filter = []): void
    {
        $cacheKey = self::generateCacheKey($cacheKey, $filter);
        $filename = self::getCacheFilename($cacheKey);

        try {
            Cache::forget($cacheKey);
            Storage::delete($filename);
        } catch (Throwable $th) {
            self::debugger('error', 'Failed to delete cache and storage', $th);
            throw $th;
        }
    }
}
