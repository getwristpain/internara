<?php

Route::prefix('auth')->middleware(['guest'])->group(function () {
    Route::get('/login', fn () => 'Login page not implemented yet.')
        ->name('auth.login');

    Route::get('/forgot-password', fn () => 'Forgot password page not implemented yet.')
        ->name('auth.forgot-password');

    Route::get('/reset-password/{token}', fn () => 'Reset password page not implemented yet.')
        ->name('auth.reset-password');
});
