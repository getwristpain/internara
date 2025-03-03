<div class="p-8 wh-full">
    <div class="flex flex-col max-w-4xl gap-12 mx-auto wh-full">
        <div class="flex flex-col text-center">
            <h1 class="text-heading-lg">Jurusan dan Kelas</h1>
            <p>Atur jurusan dan kelas yang tersedia di sekolah.</p>
        </div>

        <div class="flex-1">
            @livewire('departments.department-setting', key(App\Helpers\Helper::key('department-setting')))
        </div>

        <div class="flex items-center justify-end gap-4">
            <x-button class="btn-ghost" action="back">Kembali</x-button>
            <x-button class="btn-primary" action="$dispatch('save-departments-clicked')">Lanjut</x-button>
        </div>
    </div>
</div>
