@props([
    'list' => 'departments',
    'addAction' => 'add',
])

<div class="wh-full flex flex-col items-center justify-center gap-12">
    <x-ui.form class="w-full px-4 py-3" :submit="$addAction" bordered>
        <div class="flex w-full flex-nowrap gap-4" x-data>
            <x-ui.field type="text" field="form.data.name" placeholder="Masukkan nama jurusan..." required autofocus />
            <x-ui.button class="max-sm:btn-square my-2 flex-row-reverse" :style="['label' => 'hidden sm:inline']" label="Tambah" color="primary"
                icon="mdi:plus" title="Tambah Jurusan" :action="$addAction" :target="$addAction" />
        </div>
    </x-ui.form>

    <div class="flex w-full max-w-4xl flex-1 flex-wrap justify-center gap-4" x-data="{
        departments: @entangle($list).live ?? [],
        remove(id, index) {
            this.departments.splice(index, 1);
            $wire.remove(id);
        }
    }">
        <template x-for="(dept, index) in departments" :key="index">
            <div
                class="flex items-center justify-between gap-2 rounded-xl border border-neutral-400 px-4 py-2 transition duration-300 ease-in-out hover:bg-gradient-to-br hover:from-neutral-100 hover:to-neutral-200/80">
                <span class="text-neutral truncate" x-text="dept.name"></span>
                <x-ui.button class="btn-circle btn-xs border-none bg-transparent text-neutral-700 hover:text-red-500"
                    icon="tabler-x" x-on:click="remove(dept.id, index)" />
            </div>
        </template>

        <template x-if="departments.length === 0">
            <span class="text-medium">Belum ada jurusan ditambahkan.</span>
        </template>
    </div>
</div>
