<?php

namespace App\Services;

use App\Models\Setting;
use App\Services\Service;
use Illuminate\Support\Arr;

class SettingService extends Service
{
    public function get(string|array $keys, mixed $default = null): mixed
    {
        if (is_array($keys)) {
            $model = Setting::whereIn('key', $keys)->get();

            return $model ? $model->map(fn ($i) => $i['value'] ?? null)->toArray() : $default;
        }

        return Setting::where(['keys' => $keys])->first()?->value ?? $default;
    }

    public function set(array|string $keys, mixed $value = null): ?Setting
    {
        if (is_array($keys)) {
            if (!Arr::isAssoc($keys)) {
                throw new \InvalidArgumentException('The $keys must be associative array.');
            }

            foreach ($$keys as $key => $value) {
                $this->set($key, $value);
            }
        }

        return Setting::updateOrCreate(['key' => $keys], ['value' => $value]);
    }

    public function isInstalled(): bool
    {
        return (bool) $this->get('is_installed', false);
    }

    public function isDev(): bool
    {
        return (bool) app()->environment(['local', 'dev', 'development', 'test', 'testing']);
    }

    public function isDebug(): bool
    {
        return config('app.debug');
    }
}
