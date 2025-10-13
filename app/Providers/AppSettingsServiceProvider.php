<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppSettingsServiceProvider extends ServiceProvider
{
    protected static array $settingKeys = [
        'brand_name',
        'brand_description',
        'brand_logo',
        'brand_logo_dark',
        'is_installed',
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('app_settings', fn () => $this->getSettingsData());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('app_settings', $this->app['app_settings']);
    }

    /**
     * Retrieve shared data by fetching settings and applying defaults only when necessary.
     */
    protected function getSettingsData(): array
    {
        return setting(static::$settingKeys, default: $this->getDefaultSettings());
    }

    protected function getDefaultSettings(): array
    {
        $defaultSettings = [];
        foreach (static::$settingKeys as $key) {
            $defaultSettings[$key] = config('settings.' . $key, null);
        }

        return $defaultSettings;
    }
}
