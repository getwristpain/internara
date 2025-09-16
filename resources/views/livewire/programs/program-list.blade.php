<div x-data>
    <div class="mx-auto grid w-full max-w-6xl grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($programs as $program)
            <x-ui.card
                class="cursor-pointer border border-neutral-500 bg-neutral-900 p-4 text-neutral-100 hover:bg-neutral-700"
                shadowed wire:key="{{ 'program-' . $program['id'] }}"
                wire:click="openProgramFormModal({{ $program['id'] }})">
                <div class="flex flex-col justify-between gap-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="truncate text-sm font-bold md:text-base">
                            {{ $program['title'] }}
                        </span>
                        <span class="badge badge-sm badge-outline font-medium text-neutral-300">
                            {{ $program['year'] }}
                        </span>
                    </div>

                    <div class="flex flex-col text-xs text-neutral-300">
                        <div class="flex w-full justify-between">
                            <span>Mulai</span>
                            <span>{{ $program['date_start'] }}</span>
                        </div>

                        <div class="flex w-full justify-between">
                            <span>Selesai</span>
                            <span>{{ $program['date_end'] }}</span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        @endforeach

        <x-ui.card
            class="border-3 flex items-center justify-center border-dashed border-neutral-400 text-neutral-500 hover:bg-neutral-300 hover:text-neutral-700 max-sm:col-span-2 md:col-span-1">
            <div class="wh-full flex cursor-pointer flex-row items-center justify-center gap-4 p-4"
                x-bind:class="{ 'min-h-24': programs.length === 0 }" wire:click="openProgramFormModal">
                <x-ui.icon class="block rounded-full border-2 border-neutral-500 p-1" icon="tabler-plus" />
                <span class="block text-center font-bold lg:text-left">
                    Tambah Program
                </span>
            </div>
        </x-ui.card>
    </div>

    <x-ui.modal class="w-full max-w-2xl" show="showProgramFormModal">
        <div class="w-full">
            @livewire('programs.program-form', ['wire:model' => 'selectedProgram', 'fallbackTo' => route('setup.program')])
        </div>
    </x-ui.modal>
</div>
