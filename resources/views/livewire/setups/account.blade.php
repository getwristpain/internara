<?php

use function Livewire\Volt\{state, layout, title, form, mount, protect};

state([
    'type' => 'owner',
]);

layout('components.layouts.guest');
title('Buat Akun Administrator | ' . config('app.description'));
form(App\Livewire\Forms\RegisterForm::class);

mount(function () {
    $this->ensureReqStepsCompleted();
    $this->form->initialize($this->type);
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted('setup:welcome');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup', navigate: true);
    }
});

$next = function () {
    $res = App\Helpers\LogicResponse::make()
        ->failWhen($this->form->submit())
        ->then(app(App\Services\SetupService::class)->perform('setup:account'));

    $res->passes() ? $this->redirectRoute('setup.school', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="mx-auto flex max-w-4xl flex-1 flex-col items-center justify-center gap-12 pt-16 lg:pt-0">
    <div class="w-full space-y-1">
        <x-animate.fade-in>
            <h1 class="text-head">
                Buat Akun Administrator
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Kendalikan sistem dengan akun pusat dan kelola data secara
                penuh.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="w-full max-sm:flex-1" delay="200ms">
        @include('components.partials.auth.register-form', [
            'title' => '',
            'desc' => '',
            'submit' => 'next',
            'type' => $type,
            'shadowed' => true,
            'bordered' => true,
        ])
    </x-animate.fade-in>
</div>
