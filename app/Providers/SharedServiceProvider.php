<?php

namespace App\Providers;

use App\Helpers\Attribute;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $defaultSettings = [
            'brand_name' => config('app.name'),
            'brand_logo' => config('app.logo'),
        ];

        $this->app->singleton('shared', fn ()
            => Attribute::make([
                'settings' => setting()?->cached(array_keys($defaultSettings), $defaultSettings)
            ]));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::share('shared', app('shared'));
    }
}
