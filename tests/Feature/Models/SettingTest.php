<?php

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Setting::insert([
        [
            'key' => 'test1',
            'value' => 'testing',
            'type' => 'string'
        ],
        [
            'key' => 'test2',
            'value' => true,
            'type' => 'boolean'
        ]
    ]);
});

it('can get key-value pair with correct value type.', function () {
    $strSetting = Setting::where('key', 'test1')->first();
    $boolSetting = Setting::where('key', 'test2')->first();

    expect($strSetting->value)->toBe('testing');
    expect($boolSetting->value)->toBeTrue();
});
