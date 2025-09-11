<?php

use function Livewire\Volt\{state, layout, title, form, mount, protect};

state([
    'type' => 'owner',
    'checkValue' => 'Hello',
]);

layout('components.layouts.guest');
title('Buat Akun Administrator | ' . config('app.description'));
form(App\Livewire\Forms\RegisterForm::class);

mount(function () {
    $this->checkReqSteps();
    $this->form->initialize($this->type);

    $this->checkValue = $this->form->data['email'];
});

$checkReqSteps = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted('setup:welcome');

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute('setup', navigate: true);
    }
});

$next = function () {
    $this->form->data['email'] = 'clicked';

    // $res = App\Helpers\LogicResponse::make()
    //     ->failWhen($this->form->submit())
    //     ->then(app(App\Services\SetupService::class)->perform('setup:account'));

    // $res->passes() ? $this->redirectRoute('setup.school', navigate: true) : flash()->error($res->getMessage());
};

?>

<div class="mx-auto flex max-w-6xl flex-1 flex-col items-center justify-center gap-12 pt-8 lg:pt-0">
    <div class="w-full space-y-1 text-center">
        <x-ui.animate>
            <h1 class="text-head">
                Buat Akun Administrator
            </h1>
        </x-ui.animate>

        <x-ui.animate delay="200ms">
            <p class="text-subhead">
                Kendalikan sistem dengan akun pusat dan kelola data secara penuh.
            </p>
        </x-ui.animate>
    </div>

    <x-ui.animate class="w-full max-sm:flex-1" delay="200ms">
        @include('components.partials.auth.register-form', [
            'submit' => 'next',
            'bordered' => true,
            'shadowed' => true,
        ])
    </x-ui.animate>
</div>
