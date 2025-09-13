@props([
    'name' => 'registerForm',
    'title' => 'Registrasi Akun',
    'desc' => 'Pendaftaran akun hanya ditujukan untuk siswa',
    'type' => 'student',
    'submit' => 'submit',
    'shadowed' => false,
    'bordered' => false,
    'hideActions' => false,
])

<x-ui.form :$name :$submit :$title :$desc :$bordered :$shadowed>
    <div class="flex w-full flex-col gap-4">
        <div class="grid w-full grid-cols-1 gap-x-4 lg:grid-cols-2">
            <x-ui.field type="name" field="data.name" label="Nama" placeholder="Masukkan nama pengguna..." required
                :disabled="$type === 'owner'" />
            <x-ui.field type="email" field="data.email" label="Email" placeholder="Masukkan email pengguna..."
                required />
            <x-ui.field type="password" field="data.password" label="Kata Sandi" placeholder="Masukkan Kata Sandi..."
                required />
            <x-ui.field type="password" field="data.password_confirmation" label="Konfirmasi Kata Sandi"
                placeholder="Konfirmasi Kata Sandi..." required />
        </div>

        @if ($type !== 'owner')
            <div class="flex flex-col items-center py-4">
                <x-ui.link class="text-neutral-700" type="button" label="Sudah punya akun? Masuk"
                    url="{{ route('login') }}" />
            </div>
        @endif
    </div>

    @unless ($hideActions)
        <div class="flex w-full items-center justify-end gap-4">
            <x-ui.button type="submit" form="{{ $name }}" label="Buat Akun" loading="{{ $submit }}"
                shadowed />
        </div>
    @endunless
</x-ui.form>
