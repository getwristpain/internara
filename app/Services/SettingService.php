<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SettingService extends Service
{
    /**
     * @var \App\Models\Setting
     */
    public Model $model;

    public int $cacheDuration = 3600;

    public function __construct(Setting $settingModel)
    {
        $this->model = $settingModel;
    }

    /**
     * Clears the cache for a specific setting key.
     * @param string $key
     * @return bool
     */
    public function forgetCache(string $key): bool
    {

        return Cache::forget("setting.{$key}");
    }

    /**
     * Clears ALL individual setting caches by fetching all keys from the database.
     * INI ADALAH IMPLEMENTASI YANG MEMENUHI PERMINTAAN PENGGUNA.
     * @return int The number of cache entries deleted (approximation).
     */
    public function clearAllCache(): int
    {

        $settingKeys = $this->model::all(['key'])->pluck('key');
        $deletedCount = 0;

        foreach ($settingKeys as $key) {
            if ($this->forgetCache($key)) {
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * Main method to retrieve setting values, checking the cache first.
     * @param string|array|null $keys
     * @param mixed $default
     * @param bool $skipCache
     * @return mixed
     */
    public function get(string|array|null $keys, mixed $default = null, bool $skipCache = false): mixed
    {
        if (empty($keys)) {
            return null;
        }

        $isSingle = is_string($keys);
        $keys = (array) $keys;
        $results = [];

        foreach ($keys as $key) {
            $defaultValue = $isSingle ? $default : Arr::get($default, $key);

            $results[$key] = $skipCache
                ? $this->getDirectly($key, $defaultValue)
                : $this->getCached($key, $defaultValue);
        }

        return $isSingle ? $results[$keys[0]] : $results;
    }

    /**
     * Retrieves a single setting value from the cache, or fetches it and caches it.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getCached(string $key, mixed $default): mixed
    {
        $cacheKey = "setting.{$key}";

        return Cache::remember($cacheKey, $this->cacheDuration, fn () => $this->getDirectly($key, $default));
    }

    /**
     * Fetches a single setting value directly from the database.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getDirectly(string $key, mixed $default = null): mixed
    {
        return ($setting = $this->model::find($key)) ? $setting->value : $default;
    }

    /**
     * Updates an existing setting or creates a new one, and clears the cache.
     * @param string $key
     * @param mixed $value
     * @param array $extraData
     * @return \App\Models\Setting
     */
    public function set(string $key, mixed $value, array $extraData = []): Setting
    {
        /** @var \App\Models\Setting $setting */
        $setting = $this->model::updateOrCreate(
            ['key' => $key],
            ['value' => $value] + $extraData
        );

        $this->forgetCache($key);

        return $setting;
    }
}
