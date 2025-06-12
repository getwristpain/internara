<?php

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->setting = new Setting();

    $this->setting->insert([[
        'key' => 'test1',
        'value' => 'testing',
        'value_type' => 'string',
        'type' => 'Testing'
    ], [
        'key' => 'test2',
        'value' => true,
        'value_type' => 'boolean',
        'type' => 'testing'
    ]]);
});

it('can get key-value pair with correct value type.', function () {
    $strSetting = $this->setting->where(['key' => 'test1'])->first();
    $boolSetting = $this->setting->where(['key' => 'test2'])->first();

    expect($strSetting->value)->toBeString('testing');
    expect($boolSetting->value)->toBeTrue();
});
