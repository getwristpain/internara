@props([
    'name' => 'registerForm',
    'title' => 'Registrasi Akun',
    'desc' => 'Pendaftaran akun hanya ditujukan untuk siswa',
    'type' => 'student',
    'submit' => 'register',
    'shadowed' => false,
    'bordered' => false,
    'hideAction' => false,
])

<div class="flex w-full flex-col gap-12">
    <x-animate class="w-full">
        <x-form :$name :$submit :$title :$desc :$shadowed :$bordered>
            <div class="flex w-full flex-col gap-4">
                <div class="grid w-full grid-cols-1 gap-x-4 lg:grid-cols-2">
                    <x-input type="name" field="form.data.name" label="Nama" placeholder="Masukkan nama pengguna..."
                        required :disabled="$type === 'owner'" />
                    <x-input type="email" field="form.data.email" label="Email"
                        placeholder="Masukkan email pengguna..." required />
                    <x-input type="password" field="form.data.password" label="Kata Sandi"
                        placeholder="Masukkan Kata Sandi..." required />
                    <x-input type="password" field="form.data.password_confirmation" label="Konfirmasi Kata Sandi"
                        placeholder="Konfirmasi Kata Sandi..." required />
                </div>

                @if (!$hideAction && $type === 'student')
                    <div class="flex flex-col items-center py-4">
                        <x-button type="link" label="Sudah punya akun? Masuk" action="login" />
                    </div>
                @endif
            </div>
        </x-form>
    </x-animate>

    <x-animate class="w-full" delay="200ms">
        <div class="flex items-center justify-end gap-4">
            <x-button type="submit" form="{{ $name }}" label="Buat Akun" target="{{ $submit }}"
                shadowed />
        </div>
    </x-animate>
</div>
