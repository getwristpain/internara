<?php

use function Livewire\Volt\{state, layout, title, on};

state();

layout('components.layouts.guest');
title('Konfigurasi Sekolah | ' . config('setting.brand_name') . ' - ' . config('setti'));

on([
    'school-updated' => 'next',
]);

$next = function () {
    $this->redirect(route('setup.department'), navigate: true);
};

?>

<div class="flex h-full w-full flex-col items-center justify-center">
    <x-partials.setup.navigation previous="Buat Akun Admin" :previousUrl="route('setup.account')" label="Konfigurasi Sekolah" current="3" />

    <div class="flex w-full flex-1 flex-col items-center justify-center">
        <livewire:school.school-form bordered />
    </div>
</div>
