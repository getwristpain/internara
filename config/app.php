<?php

return [

    /**
     * The name of the application, used in notifications and UI elements.
     */
    'name' => env('APP_NAME', 'Internara'),

    /**
     * The short description of the application, used for metadata.
     */
    'description' => env('APP_DESCRIPTION', 'Sistem Informasi Manajemen PKL'),

    /**
     * The environment the application is currently running in (e.g., local, production).
     */
    'env' => env('APP_ENV', 'production'),

    /**
     * Enables or disables detailed error messages and stack traces.
     */
    'debug' => (bool) env('APP_DEBUG', false),

    /**
     * The base URL used by the console and for URL generation.
     */
    'url' => env('APP_URL', 'http://localhost'),

    /**
     * The default timezone for the application.
     */
    'timezone' => 'UTC',

    /**
     * The default locale for translations and localization.
     */
    'locale' => env('APP_LOCALE', 'en'),

    /**
     * The fallback locale used if the primary locale is unavailable.
     */
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /**
     * The locale used by the Faker library for generating fake data.
     */
    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /**
     * The cipher used by Laravel's encryption services.
     */
    'cipher' => 'AES-256-CBC',

    /**
     * The encryption key for the application.
     */
    'key' => env('APP_KEY'),

    /**
     * An array of previous encryption keys for rotating keys.
     */
    'previous_keys' => array_filter(
        explode(',', env('APP_PREVIOUS_KEYS', ''))
    ),

    /**
     * Configuration for Laravel's maintenance mode driver.
     * Supported drivers: "file", "cache"
     */
    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],
];
