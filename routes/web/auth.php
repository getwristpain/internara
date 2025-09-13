<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => 'Login Page')->name('login');
});

Route::post('logout', Logout::class)->name('logout');
