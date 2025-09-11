<?php

use function Livewire\Volt\{state, title, layout, form, mount};

title(fn() => 'Lengkapi Profil Anda | ' . setting()->cached('brand_name'));
layout('components.layouts.full');
form(\App\Livewire\Forms\ProfileForm::class);

mount(function () {
    $this->form->initialize();
});

$submit = function () {
    $res = $this->form->submit();
    flash($res->getMessage(), $res->getStatusType());

    if ($res->passes()) {
        $this->redirectRoute('student.registration.program');
    }
};

?>

<div class="mx-auto flex w-full max-w-4xl flex-1 flex-col items-center justify-center gap-8 pt-16">
    <div class="space-y-1 text-center">
        <x-animate class="w-full">
            <h1 class="text-head">
                Lengkapi Profil Anda
            </h1>
        </x-animate>

        <x-animate class="w-full" delay="200ms">
            <p class="text-subhead">
                Perbarui informasi profil Anda secara lengkap untuk mendaftar program PKL.
            </p>
        </x-animate>
    </div>

    <x-animate class="w-full" delay="400ms">
        @include('components.partials.profile.profile-form', [
            'type' => 'student',
            'shadowed' => true,
            'bordered' => true,
        ])
    </x-animate>
</div>
