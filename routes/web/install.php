<?php

use App\Livewire\Installs\Welcome;
use Illuminate\Support\Facades\Route;

Route::prefix('install')->group(function () {
    Route::get('/', Welcome::class)->name('install');
});
