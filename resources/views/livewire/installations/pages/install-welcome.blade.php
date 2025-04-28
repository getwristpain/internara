@props([
    'features' => [
        [
            'title' => 'Pendaftaran PKL',
            'icon' => 'mdi:clipboard-text',
            'description' => 'Siswa mendaftar PKL online, memilih tempat, dan admin menyetujui atau menolak.',
        ],
        [
            'title' => 'Monitoring & Laporan',
            'icon' => 'mdi:notebook-edit',
            'description' => 'Siswa unggah laporan, guru beri feedback, dan upload bukti kehadiran.',
        ],
        [
            'title' => 'Penilaian & Sertifikat',
            'icon' => 'mdi:school',
            'description' => 'Pembimbing menilai siswa, sistem merekap nilai, dan sertifikat bisa diunduh.',
        ],
    ],
])

<div class="flex flex-col gap-8 p-8 wh-full lg:flex-row">
    <div class="flex items-center justify-center flex-1 w-full p-8">
        <img class="w-full h-auto max-w-sm mx-auto scale-150 lg:-translate-y-1/4"
            src="{{ asset('images/illustrations/teamworks/teamwork-5.svg') }}" alt="Teamwork Illustration">
    </div>
    <div class="flex flex-col justify-between w-full max-w-2xl gap-8 mx-auto">
        <div class="w-full space-y-4 text-center lg:text-left lg:mx-0">
            <span class="hidden font-medium text-gray-400 lg:block">Selamat Datang!</span>
            <h1 class="text-3xl tracking-wider text-heading">Siapkan Langkah untuk Menjelajah Masa Depan</h1>
            <p class="text-lg">Bimbing siswa menapaki dunia kerja dengan sistem yang mendukung langkah mereka.</p>
        </div>
        <div class="flex-col flex-1 hidden md:flex">
            <ul class="flex flex-col h-full gap-4 justify-evenly">
                @foreach ($features as $feature)
                    <li class="flex items-center">
                        <div class="px-4 py-2">
                            <iconify-icon class="text-4xl" icon="{{ $feature['icon'] }}"></iconify-icon>
                        </div>
                        <div class="w-full">
                            <p class="font-bold">{{ $feature['title'] }}</p>
                            <p>{{ $feature['description'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="flex flex-col items-center justify-center w-full gap-4">
            <x-button class="shadow-lg btn-primary btn-wide" action="next" icon="icon-park-outline:right-c"
                reverse>Mulai Instalasi</x-button>
            <span class="text-sm font-medium">{{ 'Versi ' . $system['version'] }}</span>
        </div>
    </div>
</div>
