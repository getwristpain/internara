<?php

use function Livewire\Volt\{state, mount, layout, title, form, protect};

layout('components.layouts.guest');
title('Buat Akun Siswa | ' . setting()->cached('brand_name'));
form(App\Livewire\Forms\RegisterForm::class);

mount(function () {
    $this->form->initialize('student');
});

$register = function () {
    $res = $this->form->submit();
    $res->passes() ? $this->login(['email' => $this->form->data['email']]) : flash()->error($res->getMessage());
};

$login = protect(function (array $data) {
    $id = \App\Models\User::where('email', $data['email'])->first()?->id;

    $res = app(\App\Services\AuthService::class)->login(['id' => $id]);
    $res->passes() ? $this->redirectRoute('dashboard', navigate: true) : flash()->error($res->getMessage());
});

?>

<div class="mx-auto flex max-w-2xl flex-1 flex-col items-center gap-12 pt-16">
    <div class="space-y-1 text-center">
        <x-animate class="w-full">
            <h1 class="text-head">
                Buat Akun Siswa
            </h1>
        </x-animate>

        <x-animate class="w-full" delay="200ms">
            <p class="text-subhead">
                Kembangkan profesionalitas dalam dunia industri secara nyata untuk masa depan.
            </p>
        </x-animate>
    </div>

    <x-animate class="w-full" delay="400ms">
        @include('components.partials.auth.register-form', [
            'submit' => 'register',
            'bordered' => true,
            'shadowed' => true,
        ])
    </x-animate>
</div>
