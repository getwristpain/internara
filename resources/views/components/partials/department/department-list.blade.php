@props([
    'list' => 'departments',
    'submit' => 'add',
])

<div class="wh-full flex flex-col items-center justify-center gap-12">
    <x-form class="w-full px-4 py-3" :$submit name="departmentForm" bordered>
        <div class="flex justify-center items-center gap-4 flex-grow">
            <x-input.text type="text" field="form.data.name" placeholder="Masukkan nama jurusan..." required
                autofocus />
            <x-button class="max-sm:btn-square flex-row-reverse" :style="['label' => 'hidden sm:inline']" label="Tambah" type="submit"
                icon="mdi:plus" form="departmentForm" title="Tambah Jurusan" />
        </div>
    </x-form>

    <div class="flex-1 w-full max-w-2xl flex flex-wrap gap-4 justify-center" x-data="{
        departments: @entangle($list).live ?? [],
        remove(id, index) {
            this.departments.splice(index, 1);
            $wire.remove(id);
        }
    }">
        <template x-for="(dept, index) in departments" :key="index">
            <div class="px-4 py-2 border border-gray-400 rounded-xl transition ease-in-out duration-300 hover:bg-gray-200 flex gap-2 items-center justify-between"
                x-if="dept.id">
                <span class="text-neutral" x-text="dept.name"></span>
                <button class="btn btn-outline btn-circle btn-xs text-red-500 border-red-500 hover:bg-red-200"
                    x-on:click="remove(dept.id, index)">
                    <iconify-icon icon="tabler:trash-filled"></iconify-icon>
                </button>
            </div>
        </template>

        <template x-if="departments.length === 0">
            <span class="text-medium">Belum ada jurusan ditambahkan.</span>
        </template>
    </div>
</div>
