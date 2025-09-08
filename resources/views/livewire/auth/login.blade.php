<?php

use function Livewire\Volt\{layout, title, form};

layout('components.layouts.guest');
title('Masuk | ' . setting()->cached('brand_name'));
form(App\Livewire\Forms\LoginForm::class);

$login = function () {
    $res = $this->form->submit();
    if ($res->fails()) {
        flash()->error($res->getMessage());
        return;
    }

    if (auth()->user()->hasRole('admin')) {
        $this->redirectIntended('/admin', navigate: true);
    } else {
        $this->redirectIntended('/dashboard', navigate: true);
    }
};

?>

<div class="mx-auto flex w-full max-w-xl flex-1 flex-col items-center justify-center gap-12">
    <div class="w-full space-y-1 text-center">
        <x-animate>
            <h1 class="text-head">
                Selamat Datang Kembali!
            </h1>
        </x-animate>

        <x-animate delay="200ms">
            <p class="text-subhead">
                Masuk dan kelola aktivitas PKL Anda dengan aman.
            </p>
        </x-animate>
    </div>

    <x-animate class="w-full" delay="400ms">
        @include('components.partials.auth.login-form', [
            'submit' => 'login',
        ])
    </x-animate>
</div>
