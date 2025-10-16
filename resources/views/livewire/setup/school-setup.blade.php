<div class="flex h-full w-full flex-col items-center justify-center">
    <x-partials.setup.navigation previous="Buat Akun Admin" :previousUrl="route('setup.account')" label="Konfigurasi Sekolah" current="3" />

    <div class="flex w-full flex-1 flex-col items-center justify-center">
        <livewire:schools.school-form bordered />
    </div>
</div>
