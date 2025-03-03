<?php

use App\Livewire\Installations\InstallComplete;
use App\Livewire\Installations\InstallDepartment;
use App\Livewire\Installations\InstallOwner;
use App\Livewire\Installations\InstallSchool;
use App\Livewire\Installations\InstallWelcome;
use Illuminate\Support\Facades\Route;

Route::prefix('/install')
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/', InstallWelcome::class)->name('install');
        Route::get('/step/1', InstallSchool::class)->name('install.school');
        Route::get('/step/2', InstallDepartment::class)->name('install.department');
        Route::get('/step/3', InstallOwner::class)->name('install.owner');
        Route::get('/complete', InstallComplete::class)->name('install.complete');
    });
