<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Installations\InstallOwner;
use App\Livewire\Pages\Installations\InstallSchool;
use App\Livewire\Pages\Installations\InstallWelcome;
use App\Livewire\Pages\Installations\InstallComplete;
use App\Livewire\Pages\Installations\InstallDepartment;

Route::prefix('install')->middleware(['guest'])->group(function () {
    Route::get('/', InstallWelcome::class)
        ->name('install.welcome');

    Route::get('/school', InstallSchool::class)
        ->name('install.school');

    Route::get('/department', InstallDepartment::class)
        ->name('install.department');

    Route::get('/owner', InstallOwner::class)
        ->name('install.owner');

    Route::get('/complete', InstallComplete::class)
        ->name('install.complete');
});
