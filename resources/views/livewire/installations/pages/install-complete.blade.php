<div class="p-8 wh-full">
    <div
        class="flex flex-col wh-full gap-12 max-w-4xl mx-auto bg-white rounded-xl bg-opacity-90 drop-shadow-lg shadow-sm shadow-neutral-300 p-8">
        <div class="flex flex-col items-center justify-center gap-12">
            <h1 class="text-heading-lg">Yeay, Satu Step Lagi! 🎉</h1>
            <p>
                Anda kini dapat masuk ke dalam dashboard menggunakan akun administrator yang telah dibuat. Mulailah
                dengan mengelola data siswa, menambahkan tempat PKL, dan memonitor seluruh aktivitas praktik kerja
                lapangan dengan lebih mudah dan terstruktur.
            </p>
        </div>
        <div class="flex-1 space-y-12">
            <div class="ml-12 space-y-4">
                <p>
                    Aplikasi ini dikembangkan oleh <b>Reas Vyn (@getwristpain)</b> sebagai kontribusi untuk mendukung
                    transformasi digital dalam dunia pendidikan.
                </p>
                <p>
                    Proyek ini dibuat dengan harapan dapat mempermudah guru, siswa, dan pihak sekolah dalam mengelola
                    kegiatan
                    PKL secara efektif.
                </p>
                <p>
                    Dukungan, saran, atau pelaporan bug dapat dikirimkan melalui kontak resmi atau langsung melalui
                    repositori
                    pengembangan.
                </p>
                <p>
                    Github Repositori: <a class="text-link"
                        href="https://github.com/getwristpain/internara"><i>github.com/getwristpain/internara</i></a>
                </p>
            </div>
            <div>
                <p>
                    Terima kasih telah menggunakan aplikasi ini. Kami berharap aplikasi ini bermanfaat dan terus
                    berkembang
                    seiring kebutuhan Anda.
                </p>
            </div>
        </div>
        <div class="flex items-center justify-end">
            <x-button class="btn-primary" icon="icon-park-outline:right-c" reverse action="next">Masuk Untuk
                Melanjutkan</x-button>
        </div>
    </div>

    @teleport('body')
        <div class="fixed top-0 left-0 -z-10 wh-screen overflow-hidden">
            <img class="absolute inset-0 object-cover w-full h-full opacity-60"
                src="{{ asset('images/backgrounds/bg-congrate.png') }}" alt="Background">
        </div>
    @endteleport
</div>
