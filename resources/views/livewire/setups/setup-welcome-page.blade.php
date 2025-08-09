<?php

Livewire\Volt\layout('components.layouts.guest');
Livewire\Volt\title(
    fn() => App\Helpers\Transform::from('Selamat Datang | :app_description')
        ->replace([
            ':app_description' => config('app.description'),
        ])
        ->toString(),
);

$next = function () {
    $res = app(App\Services\SetupService::class)->perform('setup:start');
    $this->response = $res->toArray();

    dd($res);

    flash($res->getMessage(), $res->getStatusType());
    if ($res->passes()) {
        $this->redirectRoute('setup.account', navigate: true);
    }
};

?>

<div class="container min-wh-screen flex items-center justify-center flex-col gap-12 p-12">
    <div class="space-y-2 text-center">
        <x-fade-in>
            <h1 class="text-4xl font-black">Bantu Sekolah Anda Bekerja Lebih Cerdas</h1>
        </x-fade-in>

        <x-fade-in delay="200">
            <p class="text-xl text-neutral-600">
                Bangun fondasi digital yang rapi dan efisien untuk mendukung kegiatan Praktek Kerja Lapangan.
            </p>
        </x-fade-in>

        <x-fade-in class="mt-8" delay="400">
            <x-button class="btn-wide btn-lg" label="Mulai Instalasi" action="next" color="primary" />
        </x-fade-in>
    </div>
</div>
