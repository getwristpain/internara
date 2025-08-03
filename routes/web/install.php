<?php

use Illuminate\Support\Facades\Route;

Route::prefix('install')->group(function () {
    Route::get('/', fn () => 'Welcome!')->name('install');
});
