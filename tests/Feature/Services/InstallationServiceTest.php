<?php

use App\Models\User;
use App\Models\School;
use App\Models\Department;
use App\Models\Setting;
use App\Services\InstallationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->setting = Setting::factory()->create([
        'key' => 'is_installed',
        'value' => false,
        'type' => 'boolean'
        ]);

    $this->school = School::factory()->create();
    $this->department = Department::factory()->create(['school_id' => $this->school->id]);
    $this->owner = User::factory()->create(['type' => 'owner']);
});

it('passes school step if school exists', function () {
    $response = app(InstallationService::class)->performInstall('school_config');
    expect($response->passes())->toBeTrue();
});

it('fails school step if no school', function () {
    School::query()->delete();
    $response = app(InstallationService::class)->performInstall('school_config');
    expect($response->fails())->toBeTrue();
});

it('passes department step if department exists', function () {
    $response = app(InstallationService::class)->performInstall('department_setup');
    expect($response->passes())->toBeTrue();
});

it('fails department step if no department', function () {
    Department::query()->delete();
    $response = app(InstallationService::class)->performInstall('department_setup');
    expect($response->fails())->toBeTrue();
});

it('passes owner step if owner exists', function () {
    $response = app(InstallationService::class)->performInstall('owner_setup');
    expect($response->passes())->toBeTrue();
});

it('fails owner step if no owner', function () {
    User::query()->delete();
    $response = app(InstallationService::class)->performInstall('owner_setup');
    expect($response->fails())->toBeTrue();
});

it('marks welcome step as completed', function () {
    $response = app(InstallationService::class)->performInstall('welcome');
    expect($response->passes())->toBeTrue();
});

it('marks complete step and sets is_installed', function () {
    $service = app(InstallationService::class);
    $service->performInstall('welcome');
    $service->performInstall('school_config');
    $service->performInstall('department_setup');
    $service->performInstall('owner_setup');

    $response = $service->performInstall('complete');
    expect($response->passes())->toBeTrue();

    $setting = Setting::where('key', 'is_installed')->first();
    expect($setting)->not->toBeNull()
        ->and($setting->value)->toBe(true);
});

it('fails on invalid step', function () {
    $response = app(InstallationService::class)->performInstall('invalid_step');
    expect($response->fails())->toBeTrue();
});
