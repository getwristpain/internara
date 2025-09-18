<x-ui.form name="loginForm">
    <div class="grid grid-cols-1">
        <x-ui.field type="username" field="data.username" label="Email/Username" placeholder="Masukkan email/username..."
            required />
        <x-ui.field type="password" field="data.password" label="Kata Sandi" placeholder="Masukkan kata sandi..."
            required />
        <x-ui.field type="checkbox" field="data.remember" label="Ingat saya" />
    </div>
</x-ui.form>
