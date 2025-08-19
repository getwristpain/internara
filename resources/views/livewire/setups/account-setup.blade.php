<?php

use App\Services\SetupService;
use App\Helpers\LogicResponse;
use App\Helpers\Transform;
use App\Livewire\Forms\RegisterForm;
use function Livewire\Volt\{state, layout, title, form, mount, protect};

state([
    'type' => 'owner',
]);

layout('components.layouts.guest');

title(fn() => Transform::from('Buat Akun Administrator | :app_description')->replace(':app_description', config('app.description'))->toString());

form(RegisterForm::class);

mount(function () {
    $this->form->initialize($this->type);
    $this->ensureReqStepsCompleted();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(SetupService::class)->ensureStepsCompleted('setup:welcome');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup', navigate: true);
    }
});

$next = function () {
    $service = app(SetupService::class);

    $res = LogicResponse::make()
        ->failWhen($this->form->submit($this->type))
        ->then($service->perform('setup:account'));

    $res->passes() ? $this->redirectRoute('setup.school', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="flex-1 max-w-4xl mx-auto flex flex-col items-center justify-center gap-8 lg:gap-12 pt-16">
    <div class="w-full">
        <x-animate.fade-in>
            <h1 class="text-xl md:text-4xl font-black">
                Buat Akun Administrator
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="md:text-xl text-neutral-600">
                Kelola data sistem secara penuh untuk menyiapkan masa depan siswa.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="w-full max-sm:flex-1" delay="200ms">
        @include('partials.auth.register-form', [
            'submit' => 'next',
            'type' => 'owner',
            'shadowed' => true,
            'bordered' => true,
        ])
    </x-animate.fade-in>

    <x-animate.fade-in class="w-full flex justify-end" delay="400ms">
        <x-button class="md:btn-lg z-1" type="submit" label="Buat Akun" form="registerForm" shadowed />
    </x-animate.fade-in>
</div>
