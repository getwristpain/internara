<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Arr;
use App\Helpers\LogicResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class SettingService
{
    public function all(): ?Collection
    {
        try {
            return Setting::all();
        } catch (\Throwable $th) {
            LogicResponse::make()->debug($th);
            return null;
        }
    }

    public function get(string|array $keys, mixed $default = null): mixed
    {
        try {
            if (is_array($keys)) {
                $models = Setting::query()->whereIn('key', $keys)
                    ->pluck('value', 'key');

                return collect($keys)
                    ->mapWithKeys(function ($key) use ($models, $default) {
                        if (!$this->isInstalled() && str_starts_with($key, 'brand_')) {
                            return match ($key) {
                                'brand_name' => config('app.name'),
                                'brand_logo' => config('app.logo'),
                                default => null,
                            };
                        }

                        if (is_array($default) && empty($models[$key]) && isset($default[$key])) {
                            return [$key => $default['key']];
                        }

                        return [$key => $models[$key]];
                    })
                    ->toArray() ?? [];
            }

            if ($keys === 'brand_name' && !$this->isInstalled()) {
                return config('app.name');
            }

            if ($keys === 'brand_logo' && !$this->isInstalled()) {
                return config('app.logo');
            }

            return Setting::where('key', $keys)->first()?->value ?? $default;
        } catch (\Throwable $th) {
            LogicResponse::make()->debug($th);
            return null;
        }
    }

    public function cached(string|array $keys, mixed $default = null, int $ttl = 3600): mixed
    {
        try {
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
        } catch (\Throwable $th) {
            LogicResponse::make()->debug($th);
            return null;
        }
    }

    public function set(array|string $keys, mixed $value = null): Setting|int|null
    {
        try {
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
        } catch (\Throwable $th) {
            LogicResponse::make()->debug($th);
            return null;
        }
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
