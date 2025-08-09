<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['guest'])->prefix('setup')->group(function () {
    Volt::route('/', 'setups.setup-welcome-page')->name('setup');
    Volt::route('/account', 'setups.account-setup-page')->name('setup.account');
    Volt::route('/school', 'setups.school-setup-page')->name('setup.school');
    Volt::route('/department', 'setups.department-setup-page')->name('setup.department');
    Volt::route('/program', 'setups.program-setup-page')->name('setup.program');
    Volt::route('/complete', 'setups.setup-complete-page')->name('setup.complete');
});
