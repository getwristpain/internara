<?php

use App\Livewire\Pages\Installations\Completion;
use App\Livewire\Pages\Installations\DepartmentClassroom;
use App\Livewire\Pages\Installations\OwnerSetup;
use App\Livewire\Pages\Installations\SchoolSetting;
use App\Livewire\Pages\Installations\Welcome;
use Illuminate\Support\Facades\Route;

Route::prefix('/install')
    ->group(function () {
        Route::get('/', Welcome::class)->name('install');
        Route::get('/school-setting', SchoolSetting::class)->name('install.school-setting');
        Route::get('/department-classroom', DepartmentClassroom::class)->name('install.department-classroom');
        Route::get('/owner-setup', OwnerSetup::class)->name('install.owner-setup');
        Route::get('/completion', Completion::class)->name('install.completion');
    })->middleware(['guest']);
