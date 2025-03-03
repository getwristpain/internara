<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('install');
});

require __DIR__.'/web/installation.php';
require __DIR__.'/web/auth.php';
