@props([
    'submit' => null,
])

<x-form name="loginForm" :$submit bordered shadowed title="Masuk"
    desc="Pengguna baru dapat masuk menggunakan token yang telah diberikan.">
    <div class="flex flex-col">
        <div class="flex flex-col">
            <x-input field="form.data.username" type="username"
                label="Email / Username"
                placeholder="Masukkan email atau username..." required></x-input>
            <x-input field="form.data.password" type="password"
                label="Kata Sandi" placeholder="Masukkan kata sandi..."
                required></x-input>
            <x-input field="form.data.remember" type="checkbox"
                label="Ingat saya"></x-input>
        </div>

        <div class="flex items-center justify-center pb-4 pt-8">
            <a class="text-sm font-medium text-gray-700 hover:underline"
                href="{{ route('password.forgot') }}" wire:navigate>
                Lupa kata sandi?
            </a>
        </div>
    </div>
</x-form>
