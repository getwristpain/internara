<div class="w-full">
    <x-form name="register-owner-form" submit="registerOwner">
        <x-forms.input-text type="name" name="owner_name" model="owner.name" label="Nama Lengkap"
            placeholder="Masukkan nama lengkap..." required autofocus />
        <x-form.input-text type="email" name="owner_email" model="owner.email" label="Email"
            placeholder="mail@example.com" required />
        <x-forms.input-text type="password" name="owner_password" model="owner.password" label="Kata Sandi"
            placeholder="Masukkan kata sandi..." required />
        <x-forms.input-text type="password" name="owner_password_confirmation" model="owner.password_confirmation"
            label="Konfirmasi Kata Sandi" placeholder="Konfirmasi kata sandi..." required />
    </x-form>
</div>
