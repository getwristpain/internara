<div class="grid flex-1 grid-cols-1 gap-8 pt-12 lg:grid-cols-2">
    <div class="order-1 w-full space-y-1 max-md:text-center lg:order-2 lg:pt-12">
        <x-ui.animate>
            <h1 class="text-head">
                Konfigurasi Data Sekolah
            </h1>
        </x-ui.animate>

        <x-ui.animate delay="200ms">
            <p class="text-subhead">
                Informasi dasar sekolah anda digunakan untuk menyesuaikan
                kebutuhan sistem agar berjalan dengan optimal.
            </p>
        </x-ui.animate>
    </div>

    <x-ui.animate class="order-2 row-span-3 w-full lg:order-1" delay="200ms">
        @livewire('school.school-form', [
            'bordered' => true,
            'shadowed' => true,
            'hideActions' => true,
        ])
    </x-ui.animate>

    <x-ui.animate class="order-3 flex justify-end lg:justify-start" delay="400ms">
        <x-ui.button class="btn-wide" label="Simpan & Lanjutkan" type="submit" form="schoolForm" shadowed
            x-on:dirty-loading.window="loading = $event.detail.loading" />
    </x-ui.animate>
</div>
