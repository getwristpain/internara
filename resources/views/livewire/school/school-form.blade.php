@props([
    'name' => 'schoolForm',
    'title' => 'Data Sekolah',
    'desc' => 'Isi seluruh data sekolah Anda dengan benar.',
    'submit' => 'submit',
    'shadowed' => false,
    'bordered' => false,
    'hideActions' => false,
])

<x-ui.form :$name :$submit :$title :$desc :$shadowed :$bordered>
    <div class="grid grid-cols-1 gap-x-4 lg:grid-cols-2">
        <x-ui.field class="col-span-full" type="image" field="data.logo_file" label="Logo Sekolah"
            placeholder="Unggah Logo" aspect="square" preview="data.logo" />
        <x-ui.field type="business" field="data.name" label="Nama Sekolah" placeholder="Masukkan nama sekolah..."
            required />
        <x-ui.field type="email" field="data.email" label="Email Sekolah" placeholder="Masukkan email sekolah..."
            required />
        <x-ui.field type="phone" field="data.telp" label="Telp. Sekolah" placeholder="(xxx) xxxx-xxxx" required />
        <x-ui.field type="phone" field="data.fax" label="Fax. Sekolah" placeholder="(xxx) xxxx-xxxx" required />
        <x-ui.field class="col-span-full" type="address" field="data.address" label="Alamat Sekolah"
            placeholder="Masukkan alamat sekolah..." required />
        <x-ui.field type="number" field="data.postal_code" label="Kode Pos" placeholder="XXXXXX" required />
        <x-ui.field type="url" field="data.website" label="Website Sekolah" placeholder="https://www.example.com"
            required />
        <x-ui.field class="col-span-full" type="person" field="data.principal_name" label="Nama Kepala Sekolah"
            placeholder="Masukkan nama kepala sekolah..." required />
    </div>

    @unless ($hideActions)
        <div class="flex items-center justify-end gap-4">
            <x-ui.button label="Simpan" type="submit" form="{{ $name }}" loading="{{ $submit }}" shadowed />
        </div>
    @endunless
</x-ui.form>
