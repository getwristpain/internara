<?php

use App\Exceptions\AppException;
use function Livewire\Volt\{state, layout, title, on, mount};

state();

layout('components.layouts.guest');
title('Buat Akun Admin | ' . setting('brand_name') . ' - ' . setting('brand_description'));

mount(function () {
    if (!session('setup:welcome', false)) {
        $this->redirect(route('setup'), navigate: true);
    }
});

on([
    'owner-registered' => 'next',
]);

$next = function () {
    session()->put('setup:account', true);
    $this->redirect(route('setup.school'), navigate: true);
};

$exception = function ($e, $stopPropagation) {
    if ($e instanceof AppException) {
        $this->dispatch('notify-me', [
            'message' => $e->getUserMessage(),
            'type' => 'error',
        ]);
    }

    report($e);
    $stopPropagation;
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
