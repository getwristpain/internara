<?php

use App\Exceptions\AppException;
use App\Rules\Password;
use App\Services\AuthService;
use App\Services\UserService;
use function Livewire\Volt\{state, layout, title, computed};

layout('components.layouts.auth');
title('Registrasi Akun | ' . setting('brand_name') . ' - ' . setting('brand_description'));

state([
    'title' => null,
    'description' => null,
    'bordered' => false,
    'type' => 'student',
    'readyToLoad' => false,
    'data' => [
        'name' => null,
        'email' => null,
        'password' => null,
        'password_confirmation' => null,
    ],
]);

$boot = function (AuthService $authService, UserService $userService) {
    $this->authService = $authService;
    $this->userService = $userService;
};

$initialize = function () {
    if ($this->type === 'owner') {
        $this->data['name'] = 'Administrator';
    }

    $this->readyToLoad = true;
};

$getOwnerId = computed(fn() => $this->userService->getOwner()?->id)->persist();

$register = function () {
    $this->validate(
        [
            'data.name' => 'required|string|min:5|max:50',
            'data.email' => 'required|email|unique:users,email,' . $this->getOwnerId,
            'data.password' => ['required', 'confirmed', Password::auto()],
        ],
        attributes: [
            'data.name' => 'nama pengguna',
            'data.email' => 'email pengguna',
            'data.password' => 'kata sandi pengguna',
            'data.password_confirmation' => 'konfirmasi kata sandi',
        ],
    );

    $this->authService->register($this->data, $this->type);
    $this->dispatch("{$this->type}-registered");

    $this->dispatch('notify-me', [
        'message' => 'Pengguna berhasil didaftarkan.',
        'type' => 'success',
    ]);
};

$exception = function ($e, $stopPropagation) {
    if ($e instanceof AppException) {
        $this->dispatch('notify-me', [
            'message' => $e->getUserMessage(),
            'type' => 'error',
        ]);
    }

    report($e);
    $stopPropagation;
};

?>

<x-card :$bordered wire:init="initialize()">
    <x-card.header :$title :$description />
    <!-- Session Status -->
    <x-session-status class="text-center" :status="session('status')" />

    <form class="flex flex-col gap-6" method="POST" wire:submit="register">
        <!-- Name -->
        <flux:input wire:model="data.name" :label="__('Nama')" type="text" required :autofocus="$type !== 'owner'"
            autocomplete="name" :disabled="$type === 'owner'"
            :placeholder="$readyToLoad ? __('Nama lengkap') : __('Memuat....')" icon="user"
            :icon:trailing="$readyToLoad ? null : 'loading'" />

        <!-- Email Address -->
        <flux:input wire:model="data.email" :label="__('Alamat email')" type="email" required
            :autofocus="$type === 'owner'" autocomplete="email" placeholder="email@example.com" icon="envelope" />

        <!-- Password -->
        <flux:input wire:model="data.password" :label="__('Kata sandi')" type="password" required
            autocomplete="new-password" :placeholder="__('Kata sandi')" viewable icon="lock-closed" />

        <!-- Confirm Password -->
        <flux:input wire:model="data.password_confirmation" :label="__('Konfirmasi kata sandi')" type="password"
            required autocomplete="new-password" :placeholder="__('Konfirmasi kata sandi')" viewable
            icon="lock-closed" />

        <div class="flex items-center justify-end">
            <flux:button class="w-full" data-test="register-user-button" type="submit" variant="primary">
                {{ __('Buat Akun') }}
            </flux:button>
        </div>
    </form>

    @unless ($type === 'owner')
        <div class="space-x-1 text-center text-sm text-zinc-600 rtl:space-x-reverse dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    @endunless
</x-card>
