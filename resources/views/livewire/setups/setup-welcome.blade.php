<?php

// use statement
use App\Services\SetupService;
use App\Helpers\Transform;
use function Livewire\Volt\{layout, title};

// layout
layout('components.layouts.guest');

// title
title(
    fn() => Transform::from('Selamat Datang | :app_description')
        ->replace([
            ':app_description' => config('app.description'),
        ])
        ->toString(),
);

// next
$next = function () {
    $res = app(SetupService::class)->perform('setup:welcome');
    $res->passes() ? $this->redirectRoute('setup.account', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex-1 flex flex-col gap-8 items-center justify-center">
    <div class="space-y-2 text-center">
        <x-animate.fade-in>
            <h1 class="text-4xl font-black">Bantu Sekolah Anda Bekerja Lebih Cerdas</h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-xl text-gray-500">
                Bangun fondasi digital yang rapi dan efisien untuk mendukung kegiatan Praktek Kerja Lapangan.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in delay="400ms">
        <x-button class="btn-lg btn-wide" label="Mulai Instalasi" action="next" color="primary"></x-button>
    </x-animate.fade-in>
</div>
