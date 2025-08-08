@props([
    'title' => 'Registrasi Akun',
    'shadowed' => false,
    'bordered' => false,
    'type' => 'student',
    'action' => 'submit',
])

<x-form id="register-form" :$action :$title :$shadowed :$bordered>
    <div class="flex flex-col gap-4">
        <div class="flex gap-8">
            <x-input type="name" field="form.data.name" label="Nama" placeholder="Masukkan nama pengguna..." required
                disabled="{{ $type === 'owner' }}" />
            <x-input type="email" field="form.data.email" label="Email" placeholder="Masukkan email pengguna..."
                required />
        </div>
        <div class="flex gap-8">
            <x-input type="password" field="form.data.password" label="Kata Sandi" placeholder="Masukkan Kata Sandi..."
                required />
            <x-input type="password" field="form.data.password_confirmation" label="Konfirmasi Kata Sandi"
                placeholder="Konfirmasi Kata Sandi..." required />
        </div>
    </div>
</x-form>
