<?php

use App\Livewire\Dashboards\Pages\Dashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
});

require __DIR__.'/web/installation.php';
require __DIR__.'/web/auth.php';
