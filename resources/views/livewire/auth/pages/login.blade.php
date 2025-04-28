<div class="wh-full flex justify-center px-8 pt-16">
    <div class="w-full h-fit max-w-lg space-y-8 border rounded-xl p-8 shadow-lg bg-base">
        <x-form name="login-form" submit="login">
            <x-input-text required model="email" name="email" type="email" label="Email"
                placeholder="Masukkan email anda" />
            <x-input-text required model="password" name="password" type="password" label="Kata Sandi"
                placeholder="Masukkan kata sandi" />
            <x-input-checkbox model="remember" name="remember" label="Ingat saya" />
            <x-submit class="shadow-lg">Masuk</x-submit>
        </x-form>

        <div class="w-full flex flex-col items-center gap-1">
            <span>Belum punya akun? <a class="text-link" href="{{ route('register') }}">Daftar akun</a></span>
            <span>Lupa kata sandi? <a class="text-link" href="{{ route('forgot-password') }}">Klik di sini</a> </span>
        </div>
    </div>
</div>
