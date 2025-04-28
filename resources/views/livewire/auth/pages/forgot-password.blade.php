<div class="wh-full p-8">
    <div class="w-full max-w-lg mx-auto flex flex-col gap-12">
        <div class="border p-8 rounded-xl shadow-lg bg-white">
            <x-form name="forgot-password-form" submit="recoverPassword">
                <x-slot name="header">
                    <div class="text-center space-y-1">
                        <h2 class="text-heading-lg">Lupa Kata Sandi</h2>
                        <p>Masukkan email anda untuk mengatur ulang kata sandi</p>
                    </div>
                </x-slot>
                <x-slot name="body">
                    <x-input-text type="email" name="email" model="email" label="Email"
                        placeholder="Masukkan email anda" required />
                </x-slot>

                <x-slot name="footer">
                    <x-button class="btn-outline btn-neutral" action="back">Batal</x-button>
                    <x-submit>Kirim Email Pemulihan</x-submit>
                </x-slot>
            </x-form>
        </div>
    </div>
</div>
