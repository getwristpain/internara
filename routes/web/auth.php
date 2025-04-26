<?php

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
        // Route::get('/c/login', Login::class)->name('login.company');
        Route::get('/register', Register::class)->name('register');
        // Route::get('/confirm-password', Login::class)->name('confirm-password');
        Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
        // Route::get('/reset-password/{token}', Login::class)->name('reset-password');
    });
});
