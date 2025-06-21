<?php

use Illuminate\Support\Facades\Route;

foreach (glob(__DIR__ . '/web/*.php') as $routeFile) {
    require $routeFile;
}

Route::middleware(['auth'])->group(function () {
    Route::get('/', fn () => 'Hello world!')
        ->name('home');
});
