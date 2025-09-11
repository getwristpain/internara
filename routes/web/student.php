<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('registration')
    ->middleware(['web', 'auth', 'role:student'])
    ->group(function () {
        Volt::route('/', 'student.registration.profile')
            ->name('student.registration');
    });
