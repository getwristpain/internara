<?php

use App\Services\SettingService;
use App\Models\Setting;
use App\Helpers\LogicResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new SettingService();
});

describe('SettingService', function () {
    test('get returns value if setting exists', function () {
        Setting::create(['key' => 'app_name', 'value' => 'Internara']);
        $result = $this->service->get('app_name');
        expect($result)->toBe('Internara');
    });

    test('get returns default if setting does not exist', function () {
        $result = $this->service->get('not_found', 'default');
        expect($result)->toBe('default');
    });

    test('set updates existing setting', function () {
        $setting = Setting::create(['key' => 'theme', 'value' => 'light']);
        $response = $this->service->set('theme', 'dark');
        $setting->refresh();
        expect($response)->toBeInstanceOf(LogicResponse::class);
        expect($setting->value)->toBe('dark');
    });

    test('set creates new setting if not exists', function () {
        $response = $this->service->set('timezone', 'Asia/Jakarta');
        $setting = Setting::where('key', 'timezone')->first();
        expect($response)->toBeInstanceOf(LogicResponse::class);
        expect($setting)->not->toBeNull();
        expect($setting->value)->toBe('Asia/Jakarta');
    });

    test('isInstalled returns true if is_installed is true', function () {
        Setting::create(['key' => 'is_installed', 'value' => true]);
        expect($this->service->isInstalled())->toBeTrue();
    });

    test('isInstalled returns false if is_installed is false or not set', function () {
        Setting::create(['key' => 'is_installed', 'value' => false]);
        expect($this->service->isInstalled())->toBeFalse();

        Setting::where('key', 'is_installed')->delete();
        expect($this->service->isInstalled())->toBeFalse();
    });
});
