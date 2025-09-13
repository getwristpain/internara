<?php

use App\Livewire\Setups\AccountSetup;
use App\Livewire\Setups\CompleteSetup;
use App\Livewire\Setups\DepartmentSetup;
use App\Livewire\Setups\ProgramSetup;
use App\Livewire\Setups\SchoolSetup;
use App\Livewire\Setups\WelcomeSetup;
use Illuminate\Support\Facades\Route;

Route::prefix('setup')
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/welcome', WelcomeSetup::class)->name('setup');
        Route::get('/account', AccountSetup::class)->name('setup.account');
        Route::get('/school', SchoolSetup::class)->name('setup.school');
        Route::get('/department', DepartmentSetup::class)->name('setup.department');
        Route::get('/program', ProgramSetup::class)->name('setup.program');
        Route::get('/complete', CompleteSetup::class)->name('setup.complete');
    });
