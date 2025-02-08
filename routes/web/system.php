<?php

use App\Livewire\Pages\Installations\InstallFinish;
use App\Livewire\Pages\Installations\InstallStart;
use App\Livewire\Pages\Installations\SetupAccount;
use App\Livewire\Pages\Installations\SetupDepartment;
use App\Livewire\Pages\Installations\SetupSchool;
use Illuminate\Support\Facades\Route;

Route::prefix('/install')
    ->group(function () {
        Route::get('/', InstallStart::class)->name('install');
        Route::get('/setup-school', SetupSchool::class)->name('install.setup-school');
        Route::get('/setup-department', SetupDepartment::class)->name('install.setup-department');
        Route::get('/setup-account', SetupAccount::class)->name('install/setup-account');
        Route::get('/finish', InstallFinish::class)->name('install.finish');
    })->middleware(['guest']);
