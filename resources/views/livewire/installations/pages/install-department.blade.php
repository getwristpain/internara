<div class="px-8 wh-full">
    <x-stepbar currentStep="2" steps="4"></x-stepbar>

    <div class="flex flex-col max-w-4xl gap-12 mx-auto wh-full">
        <div class="flex flex-col text-center">
            <h1 class="text-heading-lg">Jurusan dan Kelas</h1>
            <p>
                Masukkan daftar jurusan yang tersedia di sekolah beserta pembagian kelas di dalamnya. Jurusan akan
                menjadi pengelompokan utama bagi data siswa, sementara kelas membantu dalam pemetaan yang lebih detail.
            </p>
        </div>

        <div class="flex-1">
            @livewire('departments.components.department-form')
        </div>

        <div class="flex items-center justify-end gap-4 pb-8">
            <x-button class="btn-ghost" action="back">Kembali</x-button>
            <x-button class="btn-primary shadow-lg" action="next" icon="icon-park-outline:right-c"
                reverse>Lanjut</x-button>
        </div>
    </div>
</div>
