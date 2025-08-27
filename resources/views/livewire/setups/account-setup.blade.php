<?php

use function Livewire\Volt\{layout, title, form, mount, protect};

layout("components.layouts.guest");
title("Buat Akun Administrator | " . config("app.description"));
form(App\Livewire\Forms\RegisterForm::class);

mount(function () {
    $this->form->initialize("owner");
    $this->ensureReqStepsCompleted();
});

$ensureReqStepsCompleted = protect(function () {
    $res = app(App\Services\SetupService::class)->ensureStepsCompleted("setup:welcome");

    if ($res->fails()) {
        flash()->error($res->getMessage());
        $this->redirectRoute("setup", navigate: true);
    }
});

$next = function () {
    $res = App\Helpers\LogicResponse::make()
        ->failWhen($this->form->submit("owner"))
        ->then(app(App\Services\SetupService::class)->perform("setup:account"));

    $res->passes() ? $this->redirectRoute("setup.school", navigate: true) : flash()->error($res->getMessage());
};

?>

<div
    class="mx-auto flex max-w-4xl flex-1 flex-col items-center justify-center gap-8">
    <div class="w-full">
        <x-animate.fade-in>
            <h1 class="text-head">
                Buat Akun Administrator
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Kelola data sistem secara penuh untuk menyiapkan masa depan
                siswa.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="w-full max-sm:flex-1" delay="200ms">
        @include("components.partials.auth.register-form", [
            "submit" => "next",
            "type" => "owner",
            "shadowed" => true,
            "bordered" => true,
        ])
    </x-animate.fade-in>

    <x-animate.fade-in class="flex w-full justify-end" delay="400ms">
        <x-button class="btn-wide" type="submit" label="Buat Akun"
            form="registerForm" shadowed />
    </x-animate.fade-in>
</div>
