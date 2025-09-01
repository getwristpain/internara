<?php

use function Livewire\Volt\{layout, title, form};

layout('components.layouts.guest');
title('Masuk | ' . setting('brand_name'));
form(App\Livewire\Forms\LoginForm::class);

$login = function () {
    $this->form->submit();
};

?>

<div
    class="mx-auto flex w-full max-w-xl flex-1 flex-col items-center justify-center gap-8">
    <div class="w-full space-y-1 text-center">
        <x-animate.fade-in>
            <h1 class="text-head">
                Selamat Datang Kembali!
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in>
            <p class="text-subhead">
                Masuk dan kelola aktivitas PKL Anda dengan aman.
            </p>
        </x-animate.fade-in>
    </div>

    <div class="w-full">
        @include('components.partials.auth.login-form', [
            'submit' => 'login',
        ])
    </div>

    <div class="flex w-full items-center justify-end">
        <x-button shadowed type="submit" form="loginForm"
            label="Masuk"></x-button>
    </div>
</div>
