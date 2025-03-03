<x-form name="school_setting_form" submit="save">
    <x-forms.input-image name="school_logo" model="school.logo" preview="school.logo_preview" label="Logo Sekolah" required />

    <div class="layout-cols">
        <x-forms.input-text name="school_name" model="school.name" label="Nama Sekolah" placeholder="Masukkan nama sekolah..."
            required />
        <x-forms.input-text type="email" name="school_email" model="school.email" label="Email Sekolah"
            placeholder="mail@example.com" />
    </div>

    <x-forms.input-address name="school_address" model="school.address" label="Alamat Sekolah" options="addressOptions" />

    <div class="layout-cols">
        <x-forms.input-text type="phone" name="school_phone" model="school.phone" label="Telepon Sekolah"
            placeholder="xxx xxxx-xxxx" />
        <x-forms.input-text type="phone" name="school_fax" model="school.fax" label="Fax. Sekolah"
            placeholder="xxx xxxx-xxxx" />
    </div>

    <x-forms.input-text type="person" name="school_principal_name" model="school.principal_name" label="Nama Kepala Sekolah"
        placeholder="Masukkan nama kepala sekolah..." />
</x-form>
