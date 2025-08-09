<?php

// Layout
Livewire\Volt\layout('components.layouts.guest');

// Title
Livewire\Volt\title(fn() => App\Helpers\Transform::from('Konfigurasi Data Sekolah | :app_desc')->replace(':app_desc', config('app.description'))->toString());

// Next
$next = function () {
    $this->redirectRoute('setup.department', navigate: true);
};

?>

<div class="min-wh-screen p-12 pt-28 container flex flex-col lg:flex-row gap-12 justify-center">

    <x-fade-in class="w-full" delay="200">
        @include('forms.school-form', ['action' => 'next', 'bordered' => true, 'shadowed' => true])
    </x-fade-in>

    <div class="space-y-2 w-full py-16">
        <x-fade-in>
            <h1 class="text-4xl font-black text-neutral">Konfigurasi Data Sekolah</h1>
        </x-fade-in>
        <x-fade-in delay="200">
            <p class="text-neutral-600 text-xl">
                Informasi dasar sekolah anda digunakan untuk menyesuaikan kebutuhan sistem agar berjalan dengan optimal.
            </p>
        </x-fade-in>
        <x-fade-in class="mt-8" delay="400">
            <x-button class="btn-lg btn-wide" label="Simpan dan Lanjutkan" type="submit" action="next" />
        </x-fade-in>
    </div>

</div>
