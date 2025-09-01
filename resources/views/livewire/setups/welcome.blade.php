<?php

use function Livewire\Volt\{layout, title};

layout('components.layouts.guest');
title('Selamat Datang | ' . config('app.description'));

$next = function () {
    $res = app(App\Services\SetupService::class)->perform('setup:welcome');
    $res->passes() ? $this->redirectRoute('setup.account', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex flex-1 flex-col items-center justify-center gap-12">
    <x-animate class="w-full lg:hidden">
        <figure class="flex flex-col items-center justify-center">
            <img class="w-full max-w-lg"
                src="{{ asset('images/drawkit/teamworks/teamwork-5.svg') }}"
                alt="Teamwork Illustration by DrawKit" />

            <caption>
                <span
                    class="w-full text-center text-xs font-medium !text-neutral-500">
                    Ilustrasi oleh DrawKit
                </span>
            </caption>
        </figure>
    </x-animate>

    <div class="flex w-full flex-col items-center justify-center gap-8">
        <div class="space-y-1 text-center">
            <x-animate>
                <h1 class="text-head">
                    Bantu Sekolah Anda Bekerja Lebih Cerdas
                </h1>
            </x-animate>

            <x-animate delay="200ms">
                <p class="text-subhead">
                    Bangun fondasi digital yang rapi dan efisien untuk mendukung
                    kegiatan Praktek Kerja Lapangan.
                </p>
            </x-animate>
        </div>

        <x-animate delay="400ms">
            <x-button class="btn-wide" label="Mulai Instalasi" action="next"
                color="primary" shadowed />
        </x-animate>
    </div>
</div>
