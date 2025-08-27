<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');
    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.forgot');
    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
