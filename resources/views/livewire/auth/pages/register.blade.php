<div class="wh-full flex flex-col items-center p-8">
    <div class="border rounded-xl p-8 mt-8 w-full max-w-lg space-y-8">
        <x-form name="register" submit="register">
            <x-input-text name="name" model="user.name" label="Nama Lengkap" placeholder="Masukkan nama lengkap"
                required />
            <x-input-text type="email" name="email" model="user.email" label="Email" placeholder="Masukkan email"
                required />
            <x-input-text type="password" name="password" model="user.password" label="Password"
                placeholder="Masukkan password" required />
            <x-input-text type="password" name="password_confirmation" model="user.password_confirmation"
                label="Konfirmasi Password" placeholder="Masukkan konfirmasi password" required />
            <div class="mt-4 w-full">
                <x-submit class="w-full">Daftar Akun</x-submit>
            </div>
        </x-form>

        <div class="w-full flex items-center justify-center gap-2 opacity-70">
            <span class="content w-full border-b-2 border-gray-300"></span>
            <span class="text-sm">atau</span>
            <span class="content w-full border-b-2 border-gray-300"></span>
        </div>

        <div class="w-full flex flex-col items-center space-y-4">
            <x-button class="btn-outline btn-neutral btn-wide">Daftar Sebagai Guru</x-button>
            <span>Sudah punya akun? <a class="text-link" href="{{ route('login') }}">Masuk</a></span>
        </div>
    </div>
</div>
