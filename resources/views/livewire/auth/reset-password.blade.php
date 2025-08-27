<?php

use function Livewire\Volt\{state, layout, title, mount};

state([
    'token' => null,
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
]);

layout('components.layouts.guest');
title('Buat Kata Sandi Baru | ' . setting('app_name'));

mount(function ($token, $email = null) {
    $this->token = $token;
    $this->user['email'] = $email;
});

$save = function () {
    $this->resetValidation();
    $this->validate(
        [
            'email' => 'required|email',
            'password' => ['required', 'confirmed', setting()->isDev() ? App\Rules\Password::bad() : App\Rules\Password::medium()],
        ],
        attributes: [
            'email' => 'email pengguna',
            'password' => 'kata sandi pengguna',
        ],
    );

    $res = app(App\Services\AuthService::class)->resetPasswordWithToken($this->email, $this->token, $this->password, $this->password_confirmation);
    flash($res->getMessage(), $res->getStatusType());

    $this->reset();
    $this->dispatch('$refresh');
};

$toLogin = function () {
    $this->redirectRoute('login', navigate: true);
};

?>

<div
    class="wh-full mx-auto flex max-w-xl flex-1 flex-col items-center gap-8 lg:pt-8">
    <div class="w-full space-y-1 text-center">
        <x-animate.fade-in>
            <h1 class="text-head">
                Buat Kata Sandi Baru
            </h1>
        </x-animate.fade-in>

        <x-animate.fade-in delay="200ms">
            <p class="text-subhead">
                Jangan bagikan kata sandi kepada siapapun. Buat kata sandi
                dengan kuat menggunakan kombinasi huruf, angka dan karakter.
            </p>
        </x-animate.fade-in>
    </div>

    <x-animate class="w-full" delay="400ms">
        <x-form name="resetPasswordForm" submit="save" bordered shadowed>
            <div class="flex flex-col">
                <x-input type="text" field="email" label="Email"
                    placeholder="Masukkan email..." required disabled />
                <x-input type="password" field="password"
                    label="Kata Sandi Baru" placeholder="Masukkan kata sandi..."
                    required />
                <x-input type="password" field="password_confirmation"
                    label="Konfirmasi Kata Sandi"
                    placeholder="Konfirmasi kata sandi..." required />
            </div>
        </x-form>
    </x-animate>

    <x-animate class="w-full" delay="200ms">
        <div class="flex items-center justify-end gap-4">
            <x-button type="button" label="Batal" action="toLogin"
                color="secondary" shadowed />

            <x-button type="submit" form="resetPasswordForm" label="Simpan"
                shadowed />
        </div>
    </x-animate>
</div>
