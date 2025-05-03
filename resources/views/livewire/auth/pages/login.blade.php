<div class="wh-full p-8 space-y-16">
    <div class="flex justify-center w-full">
        <div class="w-full h-fit max-w-lg space-y-8 border rounded-xl p-8 shadow-lg bg-base">
            <div class="w-full text-center space-y-2">
                <h1 class="text-heading-lg">Masuk</h1>
                <p>Masuk dan kelola aktivitas PKL dengan mudah. Pantau progres, unggah laporan, dan terhubung antar
                    pengguna dalam satu platform.</p>
            </div>

            <x-form name="login-form" submit="login">
                <x-input-text required model="user.email" name="email" type="email" label="Email"
                    placeholder="Masukkan email anda" />
                <x-input-text required model="user.password" name="password" type="password" label="Kata Sandi"
                    placeholder="Masukkan kata sandi" />
                <x-input-checkbox model="user.remember" name="remember" label="Ingat saya" />
                <x-submit class="shadow-lg">Masuk</x-submit>
            </x-form>

            <div class="w-full flex flex-col items-center gap-1">
                <span>Belum punya akun? <a class="text-link" href="{{ route('register') }}">Daftar akun</a></span>
                <span>Lupa kata sandi? <a class="text-link" href="{{ route('forgot-password') }}">Klik di sini</a>
                </span>
            </div>
        </div>
    </div>
</div>
