<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['guest'])->prefix('setup')->group(function () {
    Volt::route('/', 'setups.setup-welcome')->name('setup');
    Volt::route('/account', 'setups.account-setup')->name('setup.account');
    Volt::route('/school', 'setups.school-setup')->name('setup.school');
    Volt::route('/department', 'setups.department-setup')->name('setup.department');
    Volt::route('/program', 'setups.program-setup')->name('setup.program');
    Volt::route('/complete', 'setups.setup-complete')->name('setup.complete');
});
