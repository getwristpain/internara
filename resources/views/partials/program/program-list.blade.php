@props([
    'list' => 'programs',
    'add' => 'addProgram',
    'showModal' => '',
])

<div x-data="{
    programs: @entangle($list).live,
    showModal: false,
    colors: ['bg-red-200 border-red-500', 'bg-green-200 border-green-500', 'bg-blue-200 border-blue-500', 'bg-yellow-200 border-yellow-500', 'bg-purple-200 border-purple-500', 'bg-pink-200 border-pink-500'],
    getColor(index) {
        if (index === 0) {
            return this.colors[Math.floor(Math.random() * this.colors.length)]
        }
        let prevColor = this.getColor(index - 1)
        let available = this.colors.filter(c => c !== prevColor)
        return available[Math.floor(Math.random() * available.length)]
    }
}" x-on:toggle-program-modal.window="showModal = !showModal">
    <div class="wh-full flex flex-wrap gap-8 max-w-6xl mx-auto">
        <template x-for="(program, index) in programs" :key="index">
            <x-card class="p-4 border" x-bind:class="getColor(index)" x-show="program.id">
                <div class="flex flex-col gap-4 justify-between">
                    <div class="flex gap-4 items-center justify-between">
                        <span class="font-bold text-gray-900" x-text="program.title"></span>
                        <span class="badge badge-sm badge-outline font-medium text-gray-700"
                            x-text="program.year"></span>
                    </div>

                    <div class="flex flex-col text-xs text-gray-700">
                        <div class="flex justify-between w-full">
                            <span>Mulai</span>
                            <span x-text="program.date_start"></span>
                        </div>

                        <div class="flex justify-between w-full">
                            <span>Selesai</span>
                            <span x-text="program.date_start"></span>
                        </div>
                    </div>
                </div>
            </x-card>
        </template>

        <x-card
            class="border-3 border-gray-400 border-dashed bg-gray-100 hover:bg-gray-300 text-gray-500 hover:text-gray-700 flex items-center justify-center">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-center wh-full p-4 cursor-pointer"
                x-bind:class="{ 'min-h-24': programs.length === 0 }" x-on:click="showModal = !showModal" tabindex="0">
                <x-icon class="block p-1 rounded-full border-2 border-gray-500" icon="mdi:plus" />
                <span class="block font-bold text-center lg:text-left">Tambah Program</span>
            </div>
        </x-card>
    </div>

    <x-modal class="w-full max-w-2xl p-4 md:p-8" show="showModal">
        <div class="w-full space-y-8">
            <div class="w-full">
                @include('partials.program.program-form', ['submit' => $add])
            </div>

            <div class="flex justify-end w-full">
                <x-button class="flex-row-reverse" type="submit" label="Tambah" icon="mdi:plus" form="programForm"
                    action="{{ $add }}"></x-button>
            </div>
        </div>
    </x-modal>
</div>
