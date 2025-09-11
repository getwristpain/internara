<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('setup')
    ->middleware(['guest'])
    ->group(function () {
        Volt::route('/welcome', 'pages.setup.welcome-setup')->name('setup');
        Volt::route('/account', 'pages.setup.account-setup')->name('setup.account');
        Volt::route('/school', 'pages.setup.school-setup')->name('setup.school');
        Volt::route('/department', 'pages.setup.department-setup')->name('setup.department');
        Volt::route('/program', 'pages.setup.program-setup')->name('setup.program');
        Volt::route('/completion', 'pages.setup.completion-setup')->name('setup.complete');
    });
