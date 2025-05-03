<?php

use App\Livewire\Auth\Pages\ForgotPassword;
use App\Livewire\Auth\Pages\Login;
use App\Livewire\Auth\Pages\Register;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/new_user', Register::class)->name('register');
    });
});
