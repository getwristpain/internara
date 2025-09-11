<?php

use function Livewire\Volt\{layout, title, mount, protect};

layout('components.layouts.guest');
title('Instalasi Selesai | ' . config('app.description'));

mount(function () {
    $this->ensureReqStepsCompleted();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted('setup:program');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.program');
    }
});

$done = function () {
    $res = app(App\Services\SetupService::class)->perform('setup:complete');
    $res->passes() ? $this->redirectRoute('login') : flash()->error($res->getMessage());
};

?>

<div class="flex flex-1 flex-col items-center justify-center gap-12">
    <div class="space-y-1 text-center">
        <x-animate.fade-in>
            <h1 class="text-head">
                Satu Langkah Lagi!
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Seluruh komponen sudah siap. Klik 'Selesai' untuk menyelesaikan
                instalasi.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in>
        <x-card class="p-4" bordered shadowed>
            <div class="flex flex-col justify-between gap-8">
                <div>
                    <span class="font-bold">Langkah Selanjutnya: </span>
                    <ul class="list-decimal pl-8">
                        <li class="py-1">Masuk ke dashboard untuk mulai
                            menggunakan sistem.</li>
                        <li class="border-y border-gray-300 py-1">Tambahkan data
                            siswa, guru dan perusahaan.</li>
                        <li class="py-1">Nikmati kemudahan manajemen PKL
                            bersama {{ config('app.name') }}</li>
                    </ul>
                </div>

                <div class="w-full border-t border-gray-300 pt-4">
                    <x-credit />
                </div>
            </div>
        </x-card>
    </x-animate.fade-in>

    <x-animate.fade-in delay="400ms">
        <div class="flex w-full items-center justify-center">
            <x-button class="btn-wide" label="Selesai & Masuk" color="primary"
                action="done" shadowed />
        </div>
    </x-animate.fade-in>
</div>
