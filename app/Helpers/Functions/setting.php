<?php

use App\Services\SettingService;

if (!function_exists('setting')) {
    /**
     * Global helper to access the SettingService.
     * Can be used to retrieve setting values (setting('key'))
     * or get the service instance (setting()).
     *
     * @param array|string|null $key
     * @param mixed $default
     * @param bool $skipCache
     * @return mixed|\App\Services\SettingService|null
     */
    function setting(array|string|null $key = null, $default = null, bool $skipCache = false): mixed
    {
        try {
            $service = app(SettingService::class);

            if ($key !== null) {
                return $service->get($key, $default, $skipCache);
            }

            return $service;

        } catch (\Throwable $th) {
            report($th);
            return null;
        }
    }
}
