<?php

// State
Livewire\Volt\state([
    'type' => 'owner',
]);

// Layout
Livewire\Volt\layout('components.layouts.guest');

// Title
Livewire\Volt\title(fn() => App\Helpers\Transform::from('Buat Akun Administrator | :app_description')->replace(':app_description', config('app.description'))->toString());

// Form
Livewire\Volt\form(App\Livewire\Forms\RegisterForm::class);

// Mount
Livewire\Volt\mount(function () {
    $this->form->data = [
        'name' => 'Administrator',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'type' => $this->type,
    ];
});

// Next
$next = function () {
    $this->redirectRoute('setup.school', navigate: true);
};

?>

<div class="min-wh-screen container flex flex-col lg:flex-row gap-12 p-12 pt-16 justify-center items-center">
    <x-fade-in class="w-full" delay="200">
        @include('forms.register-form', [
            'action' => 'next',
            'type' => 'owner',
            'shadowed' => true,
            'bordered' => true,
        ])
    </x-fade-in>

    <div class="space-y-12 w-full">
        <div class="space-y-2">
            <x-fade-in>
                <h1 class="text-4xl font-black">
                    Buat Akun Administrator
                </h1>
            </x-fade-in>
            <x-fade-in delay="200">
                <p class="text-xl text-neutral-600">
                    Kelola data sistem secara penuh untuk menyiapkan masa depan siswa.
                </p>
            </x-fade-in>
            <x-fade-in class="mt-8" delay="400">
                <x-button class="btn-wide btn-lg" type="submit" label="Buat Akun" action="next" />
            </x-fade-in>
        </div>
    </div>
</div>
