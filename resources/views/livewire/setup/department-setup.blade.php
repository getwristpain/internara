<?php

use function Livewire\Volt\{state, layout, title};

state();

layout('components.layouts.guest');
title('Atur Jurusan | ' . setting('brand_name') . ' - ' . setting('brand_description'));

?>

<div class="flex flex-col items-center justify-center">
    <x-partials.setup.navigation previous="Konfigurasi Sekolah" :previousUrl="route('setup.school')" label="Atur Jurusan" current="4" />

    <div class="flex w-full flex-1 flex-col items-center justify-center">
        <livewire:department.department-list bordered />

        <flux:button class="w-full" variant="primary">
            Lanjutkan
        </flux:button>
    </div>
</div>
