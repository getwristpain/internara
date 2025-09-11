<?php

use function Livewire\Volt\{layout, title, form, mount, protect, usesFileUploads};

usesFileUploads();

layout('components.layouts.guest');
title('Konfigurasi Data Sekolah | ' . config('app.description'));
form(App\Livewire\Forms\SchoolForm::class);

mount(function () {
    $this->ensureReqStepsCompleted();
    $this->form->initialize();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted('setup:account');
    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.account', navigate: true);
    }
});

$next = function () {
    $res = App\Helpers\LogicResponse::make()
        ->failWhen($this->form->submit())
        ->then(app(App\Services\SetupService::class)->perform('setup:school'));

    $res->passes() ? $this->redirectRoute('setup.department', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="grid flex-1 grid-cols-1 gap-12 pt-8 lg:grid-cols-2">
    <div class="order-1 w-full space-y-1 lg:order-2 lg:pt-12">
        <x-animate.fade-in>
            <h1 class="text-head">
                Konfigurasi Data Sekolah
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Informasi dasar sekolah anda digunakan untuk menyesuaikan
                kebutuhan sistem agar berjalan dengan optimal.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="order-2 row-span-3 w-full lg:order-1" delay="200ms">
        @include('components.partials.school.school-form', [
            'submit' => 'next',
            'bordered' => true,
            'shadowed' => true,
            'hideActions' => true,
        ])
    </x-animate.fade-in>

    <x-animate.fade-in class="order-3 flex justify-end lg:justify-start" delay="400ms">
        <x-button label="Simpan & Lanjutkan" type="submit" form="schoolForm" shadowed />
    </x-animate.fade-in>
</div>
