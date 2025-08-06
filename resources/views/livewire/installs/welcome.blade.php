<div class="container wh-full flex items-center justify-center flex-col gap-16 p-16" x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 300)">
    <div class="space-y-4 text-center">
        <h1 class="text-4xl font-black" x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
            Bantu Sekolah Anda Bekerja Lebih Cerdas.
        </h1>

        <p class="text-xl text-neutral-600" x-show="show"
            x-transition:enter="transition ease-out duration-700 delay-200"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
            Bangun fondasi digital yang rapi dan efisien untuk mendukung kegiatan Praktek Kerja Lapangan.
        </p>
    </div>

    <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-400"
        x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
        <x-button class="btn-wide btn-lg" label="Mulai Instalasi" action="next" color="primary" />
    </div>
</div>
