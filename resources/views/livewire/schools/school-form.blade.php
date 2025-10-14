<?php

use function Livewire\Volt\{state};

state([
    'title' => 'Data Sekolah',
    'description' => 'Lengkapi data sekolah dengan benar.',
    'size' => 'xl',
    'bordered' => false,
]);

$save = function () {
    $this->dispatch('school-updated');
};

?>

<x-card :$size :$bordered>
    <x-card.header size="xl" :$title :$description />

    <form class="grid grid-cols-2 gap-6" wire:submit="save">
        <flux:input type="text" label="Nama sekolah" placeholder="Nama sekolah" autofocus autocomplete="school_name"
            icon="building-office" />

        <flux:input class="" type="text" label="Nama kepala sekolah" placeholder="Nama kepala sekolah"
            autocomplete="school_principal_name" icon="user" />

        <div class="col-span-full">
            <flux:textarea label="Alamat sekolah" placeholder="Alamat sekolah" autocomplete="school_address"
                rows="3" />
        </div>

        <flux:input type="tel" label="Telp. sekolah" placeholder="xx xxxx xxxx" autocomplete="school_phone"
            icon="phone" />

        <flux:input type="tel" label="Fax. sekolah" placeholder="xxx xxxx xxxx" autocomplete="school_fax"
            icon="phone" />

        <flux:input type="text" label="Email sekolah" placeholder="Email sekolah" autocomplete="school_email"
            icon="envelope" />

        <flux:input type="text" label="Website sekolah" placeholder="https://example.sch.id"
            autocomplete="school_website" icon="globe-alt" />

        <flux:button class="col-span-full w-full" type="submit" variant="primary">Simpan</flux:button>
    </form>
</x-card>
