<?php

use function Livewire\Volt\{state, computed};

state([
    'title' => 'Atur Jurusan Sekolah',
    'description' => 'Kelola daftar jurusan sekolah Anda.',
    'bordered' => false,
]);

$departments = computed(fn() => []);

?>

<div class="h-full w-full">
    <x-card>
        <x-card.header>
            <div>
                Daftar Jurusan
            </div>

            <div>
                <flux:button variant="primary" icon="plus">
                    Tambah
                </flux:button>
            </div>
        </x-card.header>

        <div class="flex flex-col gap-6">
            @forelse ($departments as $dept)
                <div>
                    <div class="flex items-center justify-between">
                        // Department list
                    </div>

                    <div>
                        // Department detail dropdown
                    </div>
                </div>
            @empty
                <div class="w-full p-4">
                    Belum ada jurusan ditambahkan.
                </div>
            @endforelse
        </div>
    </x-card>

    <flux:modal>
        // Department form modal
    </flux:modal>
</div>
