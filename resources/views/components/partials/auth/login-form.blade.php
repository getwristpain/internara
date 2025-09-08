@props([
    'name' => 'loginForm',
    'submit' => null,
])

<div class="flex w-full flex-col gap-12">
    <x-form :$name :$submit bordered shadowed title="Masuk"
        desc="Pengguna baru dapat masuk menggunakan token yang telah diberikan.">
        <div class="flex flex-col">
            <div class="flex flex-col">
                <x-input field="form.data.username" type="username" label="Email / Username"
                    placeholder="Masukkan email atau username..." required></x-input>
                <x-input field="form.data.password" type="password" label="Kata Sandi"
                    placeholder="Masukkan kata sandi..." required></x-input>
                <x-input field="form.data.remember" type="checkbox" label="Ingat saya"></x-input>
            </div>

            <div class="flex items-center justify-center pb-4 pt-8">
                <x-button type="link" label="Lupa kata sandi?" action="password.forgot" />
            </div>
        </div>
    </x-form>

    <div class="flex w-full items-center justify-end gap-4">
        <x-button type="link" color="secondary" label="Buat Akun Siswa" action="register" shadowed />
        <x-button type="submit" form="{{ $name }}" label="Masuk" shadowed />
    </div>
</div>
