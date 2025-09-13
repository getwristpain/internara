@props([
    'list' => 'programs',
    'submit' => 'submit',
    'showModal' => '',
    'addAction' => 'add',
])

@php
    $btnSubmitLabel = $action === 'add' ? 'Tambah' : 'Simpan';
    $btnSubmitIcon = $action === 'add' ? 'mdi:plus' : 'famicons:save';
@endphp

<div x-data="{
    programs: @entangle($list).live,
    showModal: false,
}" x-on:toggle-program-modal.window="showModal = !showModal">
    <div class="mx-auto grid w-full max-w-6xl grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
        <template x-for="(program, index) in programs" :key="index">
            <x-ui.card
                class="cursor-pointer border border-neutral-500 bg-neutral-900 p-4 text-neutral-100 hover:bg-neutral-700"
                shadowed x-show="program.id" x-on:click="$wire.edit(program.id)">
                <div class="flex flex-col justify-between gap-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="truncate text-sm font-bold md:text-base" x-text="program.title"
                            x-bind:title="program.title"></span>
                        <span class="badge badge-sm badge-outline font-medium text-neutral-300"
                            x-text="program.year"></span>
                    </div>

                    <div class="flex flex-col text-xs text-neutral-300">
                        <div class="flex w-full justify-between">
                            <span>Mulai</span>
                            <span x-text="program.date_start"></span>
                        </div>

                        <div class="flex w-full justify-between">
                            <span>Selesai</span>
                            <span x-text="program.date_start"></span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </template>

        <x-ui.card
            class="border-3 flex items-center justify-center border-dashed border-neutral-400 text-neutral-500 hover:bg-neutral-300 hover:text-neutral-700 max-sm:col-span-2 md:col-span-1">
            <div class="wh-full flex cursor-pointer flex-row items-center justify-center gap-4 p-4"
                x-bind:class="{ 'min-h-24': programs.length === 0 }" x-on:click="$wire.add">
                <x-ui.icon class="block rounded-full border-2 border-neutral-500 p-1" icon="tabler-plus" />
                <span class="block text-center font-bold lg:text-left">
                    Tambah Program
                </span>
            </div>
        </x-ui.card>
    </div>

    <x-ui.modal class="w-full max-w-2xl" show="showModal">
        <div class="w-full">
            @include('components.partials.program.program-form')
        </div>

        <div class="flex w-full justify-end gap-4 pt-8" x-data="{
            program: @entangle('form.data').live,
        }">
            @if ($action === 'edit')
                <x-ui.button class="flex-row-reverse" label="Hapus" icon="tabler:trash-filled" type="button"
                    color="error" action="remove(program.id)" shadowed />
            @endif

            <x-ui.button class="flex-row-reverse" type="submit" label="{{ $btnSubmitLabel }}"
                icon="{{ $btnSubmitIcon }}" form="programForm" action="{{ $submit }}" shadowed />
        </div>
    </x-ui.modal>
</div>
