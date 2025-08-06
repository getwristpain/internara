<?php

use App\Livewire\Installs\Account;
use App\Livewire\Installs\Complete;
use App\Livewire\Installs\Department;
use App\Livewire\Installs\Program;
use App\Livewire\Installs\School;
use App\Livewire\Installs\Welcome;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->prefix('install')->group(function () {
    Route::get('/', Welcome::class)->name('install');
    Route::get('/account', Account::class)->name('install.account');
    Route::get('/school', School::class)->name('install.school');
    Route::get('/department', Department::class)->name('install.department');
    Route::get('/program', Program::class)->name('install.program');
    Route::get('/complete', Complete::class)->name('install.complete');
});
