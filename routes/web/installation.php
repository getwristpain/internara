<?php

use App\Livewire\Installations\Pages\InstallSchool;
use App\Livewire\Installations\Pages\InstallWelcome;
use Illuminate\Support\Facades\Route;

Route::prefix('/install')
    ->middleware(['guest'])
    ->group(function () {
        Route::get('/welcome', InstallWelcome::class)->name('install');
        Route::get('/step/1', InstallSchool::class)->name('install.school');
    });
