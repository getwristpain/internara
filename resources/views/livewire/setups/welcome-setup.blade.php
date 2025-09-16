@push('head')
    <link rel="preload" as="image" href="{{ asset('images/drawkit/teamworks/teamwork-5.svg') }}" type="image/svg+xml">
@endpush

<div class="flex flex-1 flex-col items-center justify-center gap-8">
    <x-ui.animate class="w-full lg:hidden">
        <figure class="flex flex-col items-center justify-center">
            <img class="w-full max-w-lg" src="{{ asset('images/drawkit/teamworks/teamwork-5.svg') }}"
                alt="Teamwork Illustration by DrawKit" />

            <caption>
                <span class="w-full text-center text-xs font-medium !text-neutral-500">
                    Ilustrasi oleh DrawKit
                </span>
            </caption>
        </figure>
    </x-ui.animate>

    <div class="flex w-full flex-col items-center justify-center gap-8">
        <div class="space-y-1 text-center">
            <x-ui.animate>
                <h1 class="text-head">
                    Bantu Sekolah Anda Bekerja Lebih Cerdas
                </h1>
            </x-ui.animate>

            <x-ui.animate delay="200ms">
                <p class="text-subhead">
                    Bangun fondasi digital yang rapi dan efisien untuk mendukung
                    kegiatan Praktek Kerja Lapangan.
                </p>
            </x-ui.animate>
        </div>

        <x-ui.animate delay="400ms">
            <x-ui.button class="btn-wide" wire:click="next" label="Mulai Instalasi" color="primary" dirty="next"
                shadowed />
        </x-ui.animate>
    </div>
</div>
