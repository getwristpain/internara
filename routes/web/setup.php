<?php

use App\Livewire\Setup\AccountSetup;
use App\Livewire\Setup\DepartmentSetup;
use App\Livewire\Setup\ProgramSetup;
use App\Livewire\Setup\SchoolSetup;
use App\Livewire\Setup\SetupComplete;
use App\Livewire\Setup\SetupWelcome;

Route::prefix('/setup')->middleware('guest')->group(function () {
    Route::get('/welcome', SetupWelcome::class)->name('setup');
    Route::get('/account', AccountSetup::class)->name('setup.account');
    Route::get('/school', SchoolSetup::class)->name('setup.school');
    Route::get('/department', DepartmentSetup::class)->name('setup.department');
    Route::get('/program', ProgramSetup::class)->name('setup.program');
    Route::get('/complete', SetupComplete::class)->name('setup.complete');
});
