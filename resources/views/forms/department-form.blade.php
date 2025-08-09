<div class="wh-full flex flex-col items-center justify-center gap-12">
    <x-form class="w-full" bordered>
        <div class="flex items-center justify-center gap-4">
            <x-input type="text" field="form.data.name" placeholder="Masukkan nama jurusan..." />
            <x-button class="btn-outline bg-neutral-500 text-white" label="Tambah" color="secondary" type="submit"
                icon="mdi:plus" />
        </div>
    </x-form>
    <div class="flex-1">
        <span>Belum ada jurusan ditambahkan</span>
    </div>
</div>
