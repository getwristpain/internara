@props([
    'shadowed' => false,
    'bordered' => false,
    'title' => 'Data Sekolah',
    'desc' => 'Isi data berikut ini dengan benar.',
])

<x-form :$title :$desc :$shadowed :$bordered>
    <div class="space-y-12">
        <div class="space-y-2">
            <div>
                <x-input type="image" field="form.data.logo_file" label="Logo Sekolah" placeholder="Unggah Logo"
                    aspect="square" required />
            </div>
            <div class="flex gap-8">
                <x-input type="business" field="form.data.name" label="Nama Sekolah"
                    placeholder="Masukkan nama sekolah..." required />
                <x-input type="email" field="form.data.email" label="Email Sekolah"
                    placeholder="Masukkan email sekolah..." />
            </div>
            <div class="flex gap-8">
                <x-input type="tel" field="form.data.telp" label="Telp. Sekolah" placeholder="(xxx) xxxx-xxxx" />
                <x-input type="tel" field="form.data.fax" label="Fax. Sekolah" placeholder="(xxx) xxxx-xxxx" />
            </div>
            <div>
                <x-input type="address" field="form.data.address" label="Alamat Sekolah"
                    placeholder="Masukkan alamat sekolah..." />
            </div>
            <div class="flex gap-8">
                <x-input type="url" field="form.data.website" label="Website Sekolah"
                    placeholder="Masukkan website sekolah..." />
                <x-input type="person" field="form.data.principal_name" label="Nama Kepala Sekolah"
                    placeholder="Masukkan nama kepala sekolah..." />
            </div>
        </div>
    </div>
</x-form>
