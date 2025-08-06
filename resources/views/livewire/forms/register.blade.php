<x-form title="Register" :$shadowed :$bordered>
    <div class="flex flex-col">
        <div class="flex gap-8">
            <x-input type="name" field="data.user.name" label="Nama" placeholder="Masukkan nama pengguna..."
                required />
            <x-input type="email" field="data.user.email" label="Email" placeholder="Masukkan email pengguna..."
                required />
        </div>
        <div class="flex gap-8">
            <x-input type="password" field="data.user.password" label="Kata Sandi" placeholder="Masukkan Kata Sandi..."
                required />
            <x-input type="password" field="data.user.password_confirmation" label="Konfirmasi Kata Sandi"
                placeholder="Konfirmasi Kata Sandi..." required />
        </div>
    </div>
</x-form>
