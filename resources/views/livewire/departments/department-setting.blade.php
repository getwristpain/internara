@props(['departments' => []])

<div class="space-y-8">
    <div class="p-4 bg-gray-100 border rounded-xl">
        <x-form name="department-form" submit="addDepartment">
            <div class="flex gap-4">
                <x-input-text type="text" wire:model="departments.new_department.name"
                    placeholder="Masukkan nama jurusan baru..." />
                <button class="btn btn-neutral" type="submit">Tambah</button>
            </div>
        </x-form>
    </div>

    @forelse ($departments as $department)
        <div>
            <div
                class="flex items-center justify-between w-full p-4 border basic-transition hover:bg-gray-100 rounded-xl">
                <span class="font-bold">Teknik Komputer dan Jaringan</span>
                <x-button class="btn-sm btn-ghost" icon="icon-park-outline:down-c" iconEffect="rotate" reverse>2
                    Kelas</x-button>
            </div>
        </div>
    @empty
        <div class="w-full p-4 border rounded-xl">
            <p class="text-center">Belum ada jurusan yang ditambahkan.</p>
        </div>
    @endforelse
</div>
