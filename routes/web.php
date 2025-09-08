<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

foreach (glob(__DIR__ . '/web/*.php') as $routeFile) {
    require  $routeFile;
}

Route::get('/', fn () => redirect()->route('login'))
    ->name('home');

Volt::route('dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');
