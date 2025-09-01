<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function all(): Collection
    {
        return Setting::all();
    }

    public function get(string|array $keys, mixed $default = null): mixed
    {
        if (is_array($keys)) {
            $models = Setting::query()->whereIn('key', $keys)
                ->pluck('value', 'key');

            return collect($keys)
                ->mapWithKeys(function ($key) use ($models) {
                    if ($key === 'brand_name' && !$this->isInstalled()) {
                        return [$key => config('app.name')];
                    }

                    if ($key === 'brand_logo' && !$this->isInstalled()) {
                        return [$key => config('app.logo')];
                    }

                    return [$key => $models[$key]];
                })
                ->toArray() ?? $default;
        }

        if ($keys === 'brand_name' && !$this->isInstalled()) {
            return config('app.name');
        }

        if ($keys === 'brand_logo' && !$this->isInstalled()) {
            return config('app.logo');
        }

        return Setting::where('key', $keys)->first()?->value ?? $default;
    }

    public function cached(string|array $keys, mixed $default = null, int $ttl = 3600): mixed
    {
        if (is_array($keys)) {
            return collect($keys)->mapWithKeys(fn ($k) => [
                $k => Cache::remember(
                    "settings.{$k}",
                    $ttl,
                    fn () => $this->get($k)
                )
            ])->all() ?? $default;
        }

        return Cache::remember(
            "settings.{$keys}",
            $ttl,
            fn () => $this->get($keys, $default)
        );
    }

    public function set(array|string $keys, mixed $value = null): Setting|int|null
    {
        if (is_array($keys)) {
            if (! Arr::isAssoc($keys)) {
                throw new \InvalidArgumentException('The $keys parameter must be an associative array.');
            }

            $i = 0;

            foreach ($keys as $key => $val) {
                $this->set($key, $val);
                $i++;
            }

            return $i;
        }

        $setting = Setting::updateOrCreate(
            ['key' => $keys],
            ['value' => $value]
        );

        Cache::put("settings.{$keys}", $value, now()->addHour());
        return $setting;
    }

    public function isInstalled(): bool
    {
        return (bool) $this->get('is_installed', false);
    }

    public function isDev(): bool
    {
        return app()->environment(['local', 'dev', 'development', 'test', 'testing']);
    }

    public function isDebug(): bool
    {
        return (bool) config('app.debug');
    }
}
