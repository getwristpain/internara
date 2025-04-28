<?php

use App\Livewire\Auth\Pages\ForgotPassword;
use App\Livewire\Auth\Pages\Login;
use App\Livewire\Auth\Pages\Register;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/register', Register::class)->name('register');
        Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
    });
});
