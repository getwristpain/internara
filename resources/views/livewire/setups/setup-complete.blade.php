<?php

// Layout
Livewire\Volt\layout('components.layouts.guest');

// Title
Livewire\Volt\title(fn() => App\Helpers\Transform::from('Instalasi Selesai | :app_desc')->replace(':app_desc', config('app.description'))->toString());

// Done
$done = function () {
    $this->redirectRoute('login');
};

?>

<div class="min-wh-screen flex flex-col gap-12 p-12 pt-24 items-center justify-center">
    //
</div>
