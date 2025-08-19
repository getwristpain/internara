<?php

use App\Services\SetupService;
use App\Helpers\LogicResponse;
use App\Helpers\Transform;
use App\Livewire\Forms\SchoolForm;
use function Livewire\Volt\{layout, title, form, mount, protect, usesFileUploads};

usesFileUploads();

layout('components.layouts.guest');

title(fn() => Transform::from('Konfigurasi Data Sekolah | :app_desc')->replace(':app_desc', config('app.description'))->toString());

form(SchoolForm::class);

mount(function () {
    $this->form->initialize();
    $this->ensureReqStepsCompleted();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(SetupService::class)->ensureStepsCompleted('setup:account');
    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup.account', navigate: true);
    }
});

$next = function () {
    $service = app(SetupService::class);

    $res = LogicResponse::make()
        ->failWhen($this->form->submit())
        ->then($service->perform('setup:school'));

    $res->passes() ? $this->redirectRoute('setup.department', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex-1 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 pt-16">
    <div class="w-full order-1 lg:order-2 lg:pt-12">
        <x-animate.fade-in>
            <h1 class="text-xl md:text-4xl font-black text-neutral">Konfigurasi Data Sekolah</h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-gray-500 text-xl">
                Informasi dasar sekolah anda digunakan untuk menyesuaikan kebutuhan sistem agar berjalan dengan
                optimal.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="w-full row-span-3 order-2 lg:order-1" delay="200ms">
        @include('partials.school.school-form', [
            'submit' => 'next',
            'bordered' => true,
            'shadowed' => true,
            'logo_preview' => $form->data['logo_path'],
        ])
    </x-animate.fade-in>

    <x-animate.fade-in class="order-3 flex justify-end lg:justify-start" delay="400ms">
        <x-button class="btn-wide lg:btn-lg" label="Simpan dan Lanjutkan" type="submit" form="schoolForm" />
    </x-animate.fade-in>
</div>
