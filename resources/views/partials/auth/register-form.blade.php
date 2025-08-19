@props([
    'title' => 'Registrasi Akun',
    'shadowed' => false,
    'bordered' => false,
    'type' => 'student',
    'submit' => null,
])

<x-form class="p-8" name="registerForm" :$submit :$title :$shadowed :$bordered>
    <div class="flex flex-col w-full">
        <div class="w-full flex flex-col md:flex-row gap-x-4">
            <x-input type="name" field="form.data.name" label="Nama" placeholder="Masukkan nama pengguna..." required
                disabled="{{ $type === 'owner' }}"></x-input>
            <x-input type="email" field="form.data.email" label="Email" placeholder="Masukkan email pengguna..."
                required></x-input>
        </div>
        <div class="flex flex-col md:flex-row gap-x-4">
            <x-input type="password" field="form.data.password" label="Kata Sandi" placeholder="Masukkan Kata Sandi..."
                required></x-input>
            <x-input type="password" field="form.data.password_confirmation" label="Konfirmasi Kata Sandi"
                placeholder="Konfirmasi Kata Sandi..." required></x-input>
        </div>
    </div>
</x-form>
