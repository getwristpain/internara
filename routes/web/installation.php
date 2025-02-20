<?php

use App\Livewire\Installations\{
    InstallComplete,
    InstallDepartment,
    InstallOwner,
    InstallSchool,
    InstallWelcome
};
use Illuminate\Support\Facades\Route;

Route::prefix('/install')
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/', InstallWelcome::class)->name('install.welcome');
        Route::get('/school', InstallSchool::class)->name('install.school');
        Route::get('/department', InstallDepartment::class)->name('install.department');
        Route::get('/owner', InstallOwner::class)->name('install.owner');
        Route::get('/complete', InstallComplete::class)->name('install.complete');
    });
