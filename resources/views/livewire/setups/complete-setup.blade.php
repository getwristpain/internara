<div class="flex flex-1 flex-col items-center justify-center gap-12">
    <div class="space-y-1 text-center">
        <x-ui.animate>
            <h1 class="text-head">
                Satu Langkah Lagi!
            </h1>
        </x-ui.animate>

        <x-ui.animate delay="200ms">
            <p class="text-subhead">
                Seluruh komponen sudah siap. Klik 'Selesai' untuk menyelesaikan
                instalasi.
            </p>
        </x-ui.animate>
    </div>

    <x-ui.animate>
        <x-ui.card class="p-8" bordered shadowed>
            <div class="flex flex-col justify-between gap-8">
                <div>
                    <span class="font-bold">Langkah Selanjutnya: </span>
                    <ul class="list-decimal pl-8">
                        <li class="py-2">Masuk ke dashboard untuk mulai
                            menggunakan sistem.</li>
                        <li class="border-y border-gray-300 py-2">Tambahkan data
                            siswa, guru dan perusahaan.</li>
                        <li class="py-2">Nikmati kemudahan manajemen PKL
                            bersama {{ config('app.name') }}</li>
                    </ul>
                </div>

                <div class="w-full border-t border-gray-300 pt-4">
                    <x-ui.credit />
                </div>
            </div>
        </x-ui.card>
    </x-ui.animate>

    <x-ui.animate delay="400ms">
        <div class="flex w-full items-center justify-center">
            <x-ui.button class="btn-wide" wire:click="next" label="Selesai & Masuk" color="primary" dirty="next"
                shadowed />
        </div>
    </x-ui.animate>
</div>
