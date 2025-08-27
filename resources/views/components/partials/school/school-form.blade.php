@props([
    'bordered' => false,
    'desc' => null,
    'shadowed' => false,
    'submit' => null,
    'title' => 'Data Sekolah',
    'logo_preview' => null,
])

<x-form name="schoolForm" :$submit :$title :$desc :$shadowed :$bordered>
    <div class="flex flex-col">
        <x-input.image field="form.data.logo_file" label="Logo Sekolah"
            placeholder="Unggah Logo" aspect="square" required
            preview="{{ $logo_preview }}" />

        <div class="flex flex-col gap-x-4 md:flex-row">
            <x-input.text type="bussiness" field="form.data.name"
                label="Nama Sekolah" placeholder="Masukkan nama sekolah..."
                required />
            <x-input.text type="email" field="form.data.email"
                label="Email Sekolah" placeholder="Masukkan email sekolah..."
                required />
        </div>

        <div class="flex flex-col gap-x-4 md:flex-row">
            <x-input.text type="tel" field="form.data.telp"
                label="Telp. Sekolah" placeholder="(xxx) xxxx-xxxx" required />
            <x-input.text type="tel" field="form.data.fax"
                label="Fax. Sekolah" placeholder="(xxx) xxxx-xxxx" required />
        </div>

        <x-input.text type="address" field="form.data.address"
            label="Alamat Sekolah" placeholder="Masukkan alamat sekolah..."
            required />

        <div class="flex flex-col gap-x-4 md:flex-row">
            <x-input.text type="url" field="form.data.website"
                label="Website Sekolah" placeholder="https://www.example.com"
                required />
            <x-input.text type="person" field="form.data.principal_name"
                label="Nama Kepala Sekolah"
                placeholder="Masukkan nama kepala sekolah..." required />
        </div>
    </div>
</x-form>
