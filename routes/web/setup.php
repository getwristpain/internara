<?php

use Livewire\Volt\Volt;

Route::prefix('/setup')->middleware('guest')->group(function () {
    Volt::route('/welcome', 'setup.welcome')->name('setup');
    Volt::route('/account', 'setup.account-setup')->name('setup.account');
    Volt::route('/school', 'setup.school-setup')->name('setup.school');
    Volt::route('/department', 'setup.department-setup')->name('setup.department');
    Volt::route('/program', 'setup.program-setup')->name('setup.program');
    Volt::route('/complete', 'setup.setup-complete')->name('setup.complete');
});
