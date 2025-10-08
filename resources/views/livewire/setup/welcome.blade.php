<?php

use function Livewire\Volt\{state, layout, title, mount};

state();

layout('components.layouts.guest');
title('Selamat Datang di ' . setting('brand_name') . ' | ' . setting('brand_description'));

mount(function () {
    if (setting('is_installed', false)) {
        $this->redirect(route('login'), navigate: true);
    }
});

$next = function () {
    $this->redirect(route('setup.account'));
};

?>

<div class="mx-auto flex h-full w-full flex-col items-center justify-center gap-8 text-center">
    <div class="w-full">
        <flux:heading size="xl" level="1">
            Bantu Siswa Anda Fokus pada Skill, Bukan pada Administrasi 🎯
        </flux:heading>

        <flux:subheading size="xl">
            Kami akan membantu menghilangkan laporan yang berlarut-larut. Siswa Anda dapat mencatat progress dan laporan
            dengan mudah dan akurat.
        </flux:subheading>
    </div>

    <div>
        <flux:button variant="primary" wire:click="next">
            Mulai Instalasi
        </flux:button>
    </div>

    <x-notify-me />
</div>
