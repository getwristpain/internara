<?php

use App\Livewire\Installations\Pages\InstallComplete;
use App\Livewire\Installations\Pages\InstallDepartment;
use App\Livewire\Installations\Pages\InstallOwner;
use App\Livewire\Installations\Pages\InstallSchool;
use App\Livewire\Installations\Pages\InstallWelcome;
use Illuminate\Support\Facades\Route;

Route::prefix('/install')
    ->middleware(['guest', 'throttle:10'])
    ->group(function () {
        Route::get('/welcome', InstallWelcome::class)->name('install');
        Route::get('/step/1', InstallSchool::class)->name('install.school');
        Route::get('/step/2', InstallDepartment::class)->name('install.departments');
        Route::get('/step/3', InstallOwner::class)->name('install.owner');
        Route::get('/complete', InstallComplete::class)->name('install.complete');
    });
