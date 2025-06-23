<?php

use Illuminate\Support\Facades\Route;
use App\Services\SettingService;
use App\Http\Middleware\InstalledMiddleware;

beforeEach(function () {
    Route::middleware(InstalledMiddleware::class)->get('/test', fn () => 'OK');
});

describe('InstalledMiddleware', function () {

    test('redirects to install.welcome when not installed and not on install route', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->andReturnFalse();
        $this->instance(SettingService::class, $mock);

        $this->get('/test')->assertRedirect(route('install.welcome'));
    });

    test('redirects to auth.login when installed and accessing install route', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->twice()->andReturnTrue();
        $this->instance(SettingService::class, $mock);

        Route::middleware(InstalledMiddleware::class)->get('/install/setup', fn () => 'OK');
        $this->get('/install/setup')->assertRedirect(route('auth.login'));
    });

    test('passes through when installed and not on install route', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->twice()->andReturnTrue();
        $this->instance(SettingService::class, $mock);

        $this->get('/test')->assertOk()->assertSee('OK');
    });

    test('passes through when not installed and accessing install route', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->twice()->andReturnFalse();
        $this->instance(SettingService::class, $mock);

        Route::middleware(InstalledMiddleware::class)->get('/install/welcome', fn () => 'Installer page');
        $this->get('/install/welcome')->assertOk()->assertSee('Installer page');
    });

    test('passes through when not installed and is livewire request', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->andReturnFalse();
        $this->instance(SettingService::class, $mock);

        // Simulasi request Livewire
        Route::middleware(InstalledMiddleware::class)->get('/livewire/message', fn () => 'Livewire OK');
        $this->get('/livewire/message', [
            'X-Livewire' => 'true',
        ])->assertOk()->assertSee('Livewire OK');
    });

    test('passes through when not installed and is livewire request via path', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->andReturnFalse();
        $this->instance(SettingService::class, $mock);

        Route::middleware(InstalledMiddleware::class)->get('/livewire/test', fn () => 'Livewire Path OK');
        $this->get('/livewire/test')->assertOk()->assertSee('Livewire Path OK');
    });

    test('passes through when not installed and is livewire request via header', function () {
        $mock = $this->mock(SettingService::class);
        $mock->shouldReceive('isInstalled')->andReturnFalse();
        $this->instance(SettingService::class, $mock);

        Route::middleware(InstalledMiddleware::class)->get('/test', fn () => 'Livewire Header OK');
        $this->get('/test', [
            'X-Requested-With' => 'livewire:load',
        ])->assertOk()->assertSee('Livewire Header OK');
    });

});
