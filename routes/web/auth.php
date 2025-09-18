<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Auth\LoginForm;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
});

Route::post('logout', Logout::class)->name('logout');
