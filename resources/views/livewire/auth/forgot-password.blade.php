<?php

use function Livewire\Volt\{state, layout, title};

state([
    'email' => '',
]);

layout('components.layouts.guest');
title('Lupa Kata Sandi | ' . setting('app_name'));

$send = function () {
    $this->resetValidation();
    $this->validate(
        [
            'email' => 'required|email',
        ],
        attributes: [
            'email' => 'email pengguna',
        ],
    );

    $res = app(App\Services\AuthService::class)->sendPasswordResetLink($this->email);
    flash($res->getMessage(), $res->getStatusType());

    $this->reset();
    $this->dispatch('$refresh');
};

$toLogin = function () {
    $this->redirectRoute('login', navigate: true);
};

?>

<div
    class="mx-auto flex w-full max-w-xl flex-1 flex-col items-center gap-8 lg:pt-8">
    <div class="space-y-1 text-center">
        <x-animate.fade-in>
            <h1 class="text-head">
                Lupa Kata Sandi?
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Tidak masalah! Beri tahu kami alamat email Anda dan kami akan
                mengirimkan tautan untuk mengatur ulang kata sandi Anda yang
                baru.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate.fade-in class="w-full" delay="400ms">
        <div class="w-full">
            <x-form name="forgotPasswordForm" submit="send" bordered shadowed>
                <x-input.text type="email" field="email" label="Email"
                    placeholder="Masukkan email Anda..." required />
            </x-form>
        </div>

        <div class="mt-8 flex items-center justify-end gap-4">
            <x-button class="shadow-lg shadow-neutral-300" color="secondary"
                type="button" label="Batal" action="toLogin" />
            <x-button type="submit" form="forgotPasswordForm" label="Kirim"
                shadowed />
        </div>
    </x-animate.fade-in>
</div>
