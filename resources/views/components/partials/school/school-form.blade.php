@props([
    'name' => 'schoolForm',
    'submit' => 'submit',
    'title' => 'Data Sekolah',
    'desc' => null,
    'shadowed' => false,
    'bordered' => false,
    'hideActions' => false,
])

<div class="flex w-full max-w-6xl flex-col gap-8">
    <x-ui.animate class="w-full">
        <x-ui.form :$name :$submit :$title :$desc :$shadowed :$bordered>
            <div class="grid grid-cols-1 gap-x-4 lg:grid-cols-2">
                <x-ui.field class="col-span-full" type="image" field="form.data.logo_file" label="Logo Sekolah"
                    placeholder="Unggah Logo" aspect="square" required preview="form.data.logo" />
                <x-ui.field type="business" field="form.data.name" label="Nama Sekolah"
                    placeholder="Masukkan nama sekolah..." required />
                <x-ui.field type="email" field="form.data.email" label="Email Sekolah"
                    placeholder="Masukkan email sekolah..." required />
                <x-ui.field type="phone" field="form.data.telp" label="Telp. Sekolah" placeholder="(xxx) xxxx-xxxx"
                    required />
                <x-ui.field type="phone" field="form.data.fax" label="Fax. Sekolah" placeholder="(xxx) xxxx-xxxx"
                    required />
                <x-ui.field class="col-span-full" type="address" field="form.data.address" label="Alamat Sekolah"
                    placeholder="Masukkan alamat sekolah..." required />
                <x-ui.field type="number" field="form.data.postal_code" label="Kode Pos" placeholder="XXXXXX"
                    required />
                <x-ui.field type="url" field="form.data.website" label="Website Sekolah"
                    placeholder="https://www.example.com" required />
                <x-ui.field class="col-span-full" type="person" field="form.data.principal_name"
                    label="Nama Kepala Sekolah" placeholder="Masukkan nama kepala sekolah..." required />
            </div>
        </x-ui.form>
    </x-ui.animate>

    @unless ($hideActions)
        <x-ui.animate class="w-full" delay="200ms">
            <div class="flex items-center justify-end gap-4">
                <x-ui.button label="Simpan" type="submit" form="{{ $name }}" shadowed />
            </div>
        </x-ui.animate>
    @endunless
</div>
