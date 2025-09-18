<?php

use Illuminate\Support\Facades\Route;

// Include your route files from the 'web' directory
require __DIR__ . '/web/auth.php';
require __DIR__ . '/web/setup.php';
// Add any other route files here...

/**
 * Redirects the root URL to the login page.
 * The redirect method is more efficient than a full route handler.
 */
Route::redirect('/', '/login')
    ->name('home');
