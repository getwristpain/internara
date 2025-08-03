<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    /**
     * @return SettingService|mixed
     */
    function setting(string|array|null $keys = null, mixed $value = null, mixed $default = null): mixed
    {
        $service = app(SettingService::class);

        if (isset($value) || (is_array($keys)) && Arr::isAssoc($keys)) {
            return $service->set($keys, $value);
        }

        return $keys ? $service->get($keys, $default) : $service;
    }
}
