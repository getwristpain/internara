@props([
    'departments' => [],
])

<div class="wh-full flex flex-col items-center justify-center gap-12">
    {{-- Department Form --}}
    <x-ui.form class="w-full px-4 py-3" submit="add" bordered>
        <div class="flex w-full flex-nowrap gap-4">
            <x-ui.field type="text" field="data.name" placeholder="Masukkan nama jurusan..." required autofocus />

            <button class="btn btn-primary max-md:btn-square my-2 rounded-xl" type="submit">
                <x-ui.icon icon="tabler-plus" />
                <span class="max-md:hidden">Tambah</span>
            </button>
        </div>
    </x-ui.form>

    {{-- Department Data --}}
    <div class="flex w-full max-w-4xl flex-1 flex-wrap justify-center gap-4" x-data="{
        departments: @entangle('departments').live,
        remove(id, index) {
            this.departments.splice(index, 1);
            $wire.remove(id);
        }
    }">

        {{-- Department List --}}
        <template x-for="(dept, index) in departments" :key="index">
            <div
                class="flex items-center justify-between gap-2 rounded-xl border border-neutral-400 px-4 py-2 transition duration-300 ease-in-out hover:bg-gradient-to-br hover:from-neutral-100 hover:to-neutral-200/80">
                {{-- Department Name --}}
                <span class="text-neutral truncate" x-text="dept.name"></span>
                {{-- Remove Button --}}
                <button
                    class="btn-circle btn-xs cursor-pointer border-none bg-transparent text-neutral-700 hover:text-red-500"
                    x-on:click="remove(dept.id, index)">
                    <x-ui.icon icon="tabler-x" />
                </button>
            </div>
        </template>

        {{-- Fallback --}}
        <template x-if="departments.length === 0">
            <span class="text-medium">Belum ada jurusan ditambahkan.</span>
        </template>
    </div>
</div>
