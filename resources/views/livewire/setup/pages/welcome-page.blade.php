<div class="mx-auto flex max-w-6xl flex-1 flex-col items-center justify-center gap-12">
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
                    Fokus pada Siswa, Demi Pengalaman PKL yang Bermakna ❤️✨
                </h1>
            </x-ui.animate>

            <x-ui.animate delay="200ms">
                <p class="text-subhead">
                    Dengan sistem yang rapi dan efisien, {{ $shared->settings['brand_name'] }} mendukung sekolah menjaga
                    kualitas PKL agar benar-benar memberi nilai tambah bagi perkembangan siswa.
                </p>
            </x-ui.animate>
        </div>

        <x-ui.animate delay="400ms">
            <x-ui.button class="btn-wide" label="Mulai Instalasi" action="next" color="primary" shadowed />
        </x-ui.animate>
    </div>
</div>
