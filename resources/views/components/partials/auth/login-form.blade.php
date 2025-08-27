@props([
    'submit' => null,
])

<x-form name="loginForm" :$submit bordered shadowed title="Masuk"
    desc="Pengguna baru dapat masuk menggunakan token yang telah diberikan.">
    <div class="flex flex-col">
        <div class="flex flex-col">
            <x-input.text field="form.data.username" type="username"
                label="Email / Username"
                placeholder="Masukkan email atau username..."
                required></x-input.text>
            <x-input.text field="form.data.password" type="password"
                label="Kata Sandi" placeholder="Masukkan kata sandi..."
                required></x-input.text>
            <x-input.checkbox field="form.data.remember" type="checkbox"
                label="Ingat saya"></x-input.checkbox>
        </div>

        <div class="flex items-center justify-center pb-4 pt-8">
            <a class="text-sm font-medium text-gray-700 hover:underline"
                href="{{ route('password.forgot') }}">
                Lupa kata sandi?
            </a>
        </div>
    </div>
</x-form>
