<?php

\Livewire\Volt\state();
\Livewire\Volt\layout('components.layouts.guest');
\Livewire\Volt\title('Selamat Datang di ' . setting('brand_name') . ' | ' . setting('brand_description'));

\Livewire\Volt\mount(function () {});

$next = function () {
    $this->dispatch('notify-me', [
        'message' => 'Postingan berhasil disimpan!',
        'type' => 'success',
    ]);

    // $this->redirect(route('setup.account'));
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
