<?php

use App\Helpers\LogicResponse;
use App\Services\InstallationService;
use Livewire\Livewire;
use App\Livewire\Pages\Installations\InstallWelcome;
use App\Livewire\Pages\Installations\InstallSchool;
use App\Livewire\Pages\Installations\InstallDepartment;
use App\Livewire\Pages\Installations\InstallOwner;
use App\Livewire\Pages\Installations\InstallComplete;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->installationService = $this->mock(InstallationService::class);
    $this->instance(InstallationService::class, $this->installationService);
});

describe('Installation Livewire Pages', function () {
    test('InstallWelcome next step success', function () {
        $this->installationService->shouldReceive('performInstall')
            ->with('welcome')->andReturn(LogicResponse::make()->success('SUCCESS'));

        Livewire::test(InstallWelcome::class)
            ->call('next')
            ->assertDispatched('install:step-success');
    });

    test('InstallWelcome next step fails', function () {
        $this->installationService->shouldReceive('performInstall')
            ->with('welcome')->andReturn(LogicResponse::make()->failure('ERROR'));

        Livewire::test(InstallWelcome::class)
            ->call('next')
            ->assertDispatched('install:step-error');
    });

    // InstallSchool
    test('InstallSchool next step success', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('welcome')->andReturn(true);

        $this->installationService->shouldReceive('performInstall')
            ->with('school_config')->andReturn(LogicResponse::make()->success('SUCCESS'));

        Livewire::test(InstallSchool::class)
            ->call('next')
            ->assertDispatched('install:step-success');
    });

    test('InstallSchool next step fails', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('welcome')->andReturn(true);

        $this->installationService->shouldReceive('performInstall')
            ->with('school_config')->andReturn(LogicResponse::make()->failure('ERROR'));

        Livewire::test(InstallSchool::class)
            ->call('next')
            ->assertDispatched('install:step-error');
    });

    test('InstallSchool back', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('welcome')->andReturn(true);

        Livewire::test(InstallSchool::class)
            ->call('back')
            ->assertRedirect(route('install.welcome'));
    });

    // InstallDepartment
    test('InstallDepartment next step success', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('school_config')->andReturn(true);

        $this->installationService->shouldReceive('performInstall')
            ->with('department_setup')->andReturn(LogicResponse::make()->success('SUCCESS'));

        Livewire::test(InstallDepartment::class)
            ->call('next')
            ->assertDispatched('install:step-success');
    });

    test('InstallDepartment next step fails', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('school_config')->andReturn(true);

        $this->installationService->shouldReceive('performInstall')
            ->with('department_setup')->andReturn(LogicResponse::make()->failure('ERROR'));

        Livewire::test(InstallDepartment::class)
            ->call('next')
            ->assertDispatched('install:step-error');
    });

    test('InstallDepartment back', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('school_config')->andReturn(true);

        Livewire::test(InstallDepartment::class)
            ->call('back')
            ->assertRedirect(route('install.school'));
    });

    // InstallOwner
    test('InstallOwner next step success', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('department_setup')->andReturn(true);
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('owner_setup')->andReturn(false);

        $this->installationService->shouldReceive('performInstall')
            ->with('owner_setup')->andReturn(LogicResponse::make()->success('SUCCESS'));

        Livewire::test(InstallOwner::class)
            ->call('next')
            ->assertDispatched('install:step-success');
    });

    test('InstallOwner next step fails', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('department_setup')->andReturn(true);
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('owner_setup')->andReturn(false);

        $this->installationService->shouldReceive('performInstall')
            ->with('owner_setup')->andReturn(LogicResponse::make()->failure('ERROR'));

        Livewire::test(InstallOwner::class)
            ->call('next')
            ->assertDispatched('install:step-error');
    });

    test('InstallOwner back', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('department_setup')->andReturn(true);
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('owner_setup')->andReturn(false);

        Livewire::test(InstallOwner::class)
            ->call('back')
            ->assertRedirect(route('install.department'));
    });

    // InstallComplete
    test('InstallComplete next step success', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('owner_setup')->andReturn(true);

        $this->installationService->shouldReceive('performInstall')
            ->with('complete')->andReturn(LogicResponse::make()->success('SUCCESS'));

        Livewire::test(InstallComplete::class)
            ->call('next')
            ->assertDispatched('install:step-success')
            ->assertRedirect(route('auth.login'));
    });

    test('InstallComplete next step fails', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('owner_setup')->andReturn(true);

        $this->installationService->shouldReceive('performInstall')
            ->with('complete')->andReturn(LogicResponse::make()->failure('ERROR'));

        Livewire::test(InstallComplete::class)
            ->call('next')
            ->assertDispatched('install:step-error');
    });

    test('InstallComplete back', function () {
        $this->installationService->shouldReceive('isStepCompleted')
            ->with('owner_setup')->andReturn(true);

        Livewire::test(InstallComplete::class)
            ->call('back')
            ->assertRedirect(route('install.owner'));
    });
});
