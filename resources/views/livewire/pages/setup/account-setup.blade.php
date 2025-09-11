<?php

use function Livewire\Volt\{state, layout, title, form, mount, protect, updated};

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

updated([
    'form.data' => fn() => dd($this->form->data),
]);

$checkReqSteps = protect(function () {
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

<div class="mx-auto flex w-full max-w-2xl flex-1 flex-col justify-center gap-12 max-md:pt-12 lg:items-center">
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

    <x-ui.animate class="w-full" delay="200ms">
        @include('components.partials.auth.register-form', [
            'submit' => 'next',
            'bordered' => true,
            'shadowed' => true,
        ])
    </x-ui.animate>
</div>
