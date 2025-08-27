@props([
    'title' => 'Registrasi Akun',
    'shadowed' => false,
    'bordered' => false,
    'type' => 'student',
    'submit' => null,
])

<x-form name="registerForm" :$submit :$title :$shadowed :$bordered>
    <div class="flex w-full flex-col">
        <div class="flex w-full flex-col gap-x-4 md:flex-row">
            <x-input.text type="name" field="form.data.name" label="Nama"
                placeholder="Masukkan nama pengguna..." required
                disabled="{{ $type === 'owner' }}" />
            <x-input.text type="email" field="form.data.email" label="Email"
                placeholder="Masukkan email pengguna..." required />
        </div>
        <div class="flex flex-col gap-x-4 md:flex-row">
            <x-input.text type="password" field="form.data.password"
                label="Kata Sandi" placeholder="Masukkan Kata Sandi..."
                required />
            <x-input.text type="password"
                field="form.data.password_confirmation"
                label="Konfirmasi Kata Sandi"
                placeholder="Konfirmasi Kata Sandi..." required />
        </div>
    </div>
</x-form>
