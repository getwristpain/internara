<?php

use App\Services\SettingService;
use App\Helpers\LogicResponse;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Setting::truncate();
    Setting::insert([
        [
            'key' => 'app_name',
            'value' => 'Internara',
            'type' => 'string'
        ],
        [
            'key' => 'is_installed',
            'value' => false,
            'type' => 'boolean'
        ]
    ]);

    $this->service = new SettingService();
});

it('can set and get a setting value', function () {
    $response = $this->service->set('app_name', 'Internara');
    expect($response)->toBeInstanceOf(LogicResponse::class);

    $value = $this->service->get('app_name');
    expect($value)->toBe('Internara');
});

it('returns default value if setting does not exist', function () {
    $value = $this->service->get('not_exists', 'default');
    expect($value)->toBe('default');
});

it('can check if app is installed', function () {
    $this->service->set('is_installed', true);
    expect($this->service->isInstalled())->toBeTrue();

    $this->service->set('is_installed', false);
    expect($this->service->isInstalled())->toBeFalse();
});
