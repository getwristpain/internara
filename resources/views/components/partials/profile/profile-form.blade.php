@props([
    'name' => 'profileForm',
    'submit' => 'submit',
    'type' => 'student',
    'bordered' => false,
    'shadowed' => false,
])

<div class="flex flex-col gap-12">
    <x-form :$name :$submit :$bordered :$shadowed>
        <div class="flex w-full flex-col gap-4">
            <span class="block text-lg font-bold text-neutral-700">
                Data Diri Siswa
            </span>
            <div class="grid grid-cols-1 gap-x-4 lg:grid-cols-2">
                <x-input class="col-span-full" type="image" field="form.data.avatar_file" label="Avatar"
                    placeholder="Unggah Foto" preview="form.data.avatar_url" />
                <x-input type="person" field="form.data.name" label="Nama Lengkap"
                    placeholder="Masukkan nama lengkap..." required />
                <x-input type="text" field="form.data.identity" label="NISN/NIS" placeholder="Masukkan NISN/NIS..."
                    required />
                <x-input class="col-span-full" type="address" field="form.data.address" label="Alamat Lengkap"
                    placeholder="Dukuh, RT/RW, Desa, Kecamatan, Kabupaten" required />
                <x-input type="number" field="form.data.postal_code" label="Kode Pos" placeholder="XXXXXX" required />
                <x-input type="phone" field="form.data.phone" label="No. Telp/HP/WA" placeholder="08XXXXXXXXX"
                    required />
            </div>

            <span class="block text-lg font-bold text-neutral-700">
                Kontak Darurat
            </span>
            <div class="grid grid-cols-1 gap-x-4 lg:grid-cols-2">
                <x-input type="person" field="form.data.emergency_name" label="Nama Kontak Darurat"
                    placeholder="Masukkan nama kontak darurat..." required />
                <x-input type="select" field="form.data.emergency_relation" options="form.options.emergency_relation"
                    label="Status Hubungan" placeholder="Pilih Hubungan..." required />
                <x-field-group class="col-span-full" for="form.data.emergency_address" label="Alamat Kontak Darurat"
                    required>
                    <x-input type="address" field="form.data.emergency_address"
                        placeholder="Dukuh, RT/RW, Desa, Kecamatan, Kabupaten. Kode Pos" />
                    <x-input type="checkbox" field="form.data.mark_same_address"
                        label="Tandai sama dengan alamat siswa" />
                </x-field-group>
                <x-input class="col-span-full" type="phone" field="form.data.emergency_phone"
                    label="No. Telp/Kontak Darurat" placeholder="08XXXXXXXXX" required />
            </div>
        </div>
    </x-form>

    <div class="flex w-full items-center justify-end gap-4">
        <x-button type="submit" form="{{ $name }}" label="Simpan" />
    </div>
</div>
