<?php

return [

    'cipher' => 'AES-256-CBC',

    'debug' => (bool) env('APP_DEBUG', false),

    'env' => env('APP_ENV', 'production'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'id_ID'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'id'),

    'key' => env('APP_KEY'),

    'locale' => env('APP_LOCALE', 'id'),

    'logo' => env('APP_LOGO', 'images/logo.png'),

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'name' => env('APP_NAME', 'Internara'),

    'previous_keys' => array_filter(
        explode(',', env('APP_PREVIOUS_KEYS', ''))
    ),

    'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),

    'url' => env('APP_URL', 'http://localhost'),

    'version' => env('APP_VERSION', '1.0.0'),

];
