<?php

use App\Models\User;
use App\Models\School;
use App\Models\Department;
use App\Models\Setting;
use App\Services\InstallationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new InstallationService();

    $this->setting = Setting::factory()->create([
            'key' => 'is_installed',
            'value' => false,
            'type' => 'boolean'
        ]);

    $this->school = School::factory()->create();
    $this->department = Department::factory()->create(['school_id' => $this->school->id]);
    $this->owner = User::factory()->create(['type' => 'owner']);
});

it('fails school step if no school', function () {
    School::query()->delete();
    $response = $this->service->performInstall('school_config');
    expect($response->fails())->toBeTrue();
});

it('passes school step if school exists', function () {
    $response = $this->service->performInstall('school_config');
    expect($response->passes())->toBeTrue();
});

it('passes department step if department exists', function () {
    $response = $this->service->performInstall('department_setup');

    expect($response->passes())->toBeTrue();
});

it('fails department step if no department', function () {
    Department::query()->delete();
    $response = $this->service->performInstall('department_setup');

    expect($response->fails())->toBeTrue();
});

it('fails owner step if no owner', function () {
    User::query()->delete();
    $response = $this->service->performInstall('owner_setup');
    expect($response->fails())->toBeTrue();
});

it('passes owner step if owner exists', function () {
    $response = $this->service->performInstall('owner_setup');
    expect($response->passes())->toBeTrue();
});

it('marks welcome step as completed', function () {
    $response = $this->service->performInstall('welcome');
    expect($response->passes())->toBeTrue();
});

it('marks complete step and sets is_installed', function () {
    $this->service->performInstall('welcome');
    $this->service->performInstall('school_config');
    $this->service->performInstall('department_setup');
    $this->service->performInstall('owner_setup');

    $response = $this->service->performInstall('complete');
    expect($response->passes())->toBeTrue();

    $setting = Setting::where('key', 'is_installed')->first();
    expect($setting)->not->toBeNull()
        ->and($setting->value)->toBe(true);
});

it('fails on invalid step', function () {
    $response = $this->service->performInstall('invalid_step');
    expect($response->fails())->toBeTrue();
});
