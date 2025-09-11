<?php

use App\Helpers\LogicResponse;
use App\Services\SettingService;
use Illuminate\Support\Arr;

if (! function_exists('setting')) {
    /**
     * @return SettingService|mixed
     */
    function setting(string|array|null $keys = null, mixed $value = null, mixed $default = null): mixed
    {
        try {
            $service = app(SettingService::class);

            if ($value !== null || (is_array($keys) && Arr::isAssoc($keys))) {
                return $service->set($keys, $value);
            }

            return $keys !== null
                ? $service->get($keys, $default)
                : $service;
        } catch (\Throwable $th) {
            LogicResponse::make()
                ->error('Internal Server Error')
                ->debug($th);

            return null;
        }
    }
}
