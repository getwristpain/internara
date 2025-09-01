<?php

use function Livewire\Volt\{layout, title};

layout("components.layouts.guest");
title("Selamat Datang | " . config("app.description"));

$next = function () {
    $res = app(App\Services\SetupService::class)->perform("setup:welcome");
    $res->passes() ? $this->redirectRoute("setup.account", navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex flex-1 flex-col items-center justify-center gap-8">
    <div class="space-y-1 text-center">
        <x-animate.fade-in>
            <h1 class="text-head">
                Bantu Sekolah Anda Bekerja Lebih Cerdas
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Bangun fondasi digital yang rapi dan efisien untuk mendukung
                kegiatan Praktek Kerja Lapangan.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in delay="400ms">
        <x-button class="btn-wide" label="Mulai Instalasi" action="next"
            color="primary" shadowed />
    </x-animate.fade-in>
</div>
