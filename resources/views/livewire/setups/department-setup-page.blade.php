<?php

// Layout
Livewire\Volt\layout('components.layouts.guest');

// Title
Livewire\Volt\title(fn() => App\Helpers\Transform::from('Atur Jurusan Sekolah | :app_desc')->replace(':app_desc', config('app.description'))->toString());

// Next
$next = function () {
    $this->redirectRoute('setup.program', navigate: true);
};

?>

<div class="container min-wh-screen flex flex-col items-center justify-center p-12 pt-24 gap-12">
    <div class="space-y-2 text-center w-full">
        <x-fade-in>
            <h1 class="text-4xl font-black text-neutral">Atur Jurusan Sekolah</h1>
        </x-fade-in>
        <x-fade-in delay="200">
            <p class="text-xl text-neutral-600">Tambah dan kurang jurusan sekolah Anda dengan fleksibel.</p>
        </x-fade-in>
    </div>
    <x-fade-in class="flex-1 w-full" delay="400">
        @include('forms.department-form')
    </x-fade-in>
    <x-fade-in class="w-full flex justify-end items-center" delay="200">
        <x-button class="btn-wide btn-lg" label="Simpan dan Lanjutkan" action="next" color="primary" />
    </x-fade-in>
</div>
