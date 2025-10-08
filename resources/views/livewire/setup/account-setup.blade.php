<?php

use function Livewire\Volt\{state, layout, title, on};

state();

layout('components.layouts.guest');
title('Buat Akun Admin | ' . setting('brand_name') . ' - ' . setting('brand_description'));

on([
    'owner-registered' => 'next',
]);

$next = function () {
    $this->redirect(route('setup.school'));
};

?>

<div class="flex h-full w-full flex-col items-center justify-center">
    <x-partials.setup.navigation previous="Selamat Datang" :previousUrl="route('setup')" label="Konfigurasi Akun Administrator"
        current="2" />

    <div class="flex w-full flex-1 items-center justify-center">
        <livewire:auth.register title="Buat Akun Administrator" description="Kelola sistem dengan akun pusat."
            type="owner" bordered />
    </div>
</div>
