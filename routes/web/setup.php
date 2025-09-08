<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

if (!setting()->isInstalled()) {
    Route::prefix('setup')
        ->middleware(['guest'])
        ->group(function () {
            Volt::route('/', 'setups.welcome')->name('setup');
            Volt::route('/account', 'setups.account')->name('setup.account');
            Volt::route('/school', 'setups.school')->name('setup.school');
            Volt::route('/department', 'setups.department')->name('setup.department');
            Volt::route('/program', 'setups.program')->name('setup.program');
            Volt::route('/complete', 'setups.complete')->name('setup.complete');
        });
}
