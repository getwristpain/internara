<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('internship/register')
    ->middleware(['web', 'auth', 'role:student'])
    ->group(function () {
        Volt::route('/', 'internship.register.index')
            ->name('internship.register');
    });
