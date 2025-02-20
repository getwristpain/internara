<x-form name="school_form" submit="next">
    <x-input-image name="school_logo" model="school.logo" label="Logo Sekolah" required></x-input-image>

    <div class="layout-cols">
        <x-input-text name="school_name" model="school.name" label="Nama Sekolah" placeholder="Masukkan nama sekolah..."
            required autofocus></x-input-text>
        <x-input-text type="email" name="school_email" model="school.email" label="Email Sekolah"
            placeholder="mail@example.com"></x-input-text>
    </div>

    <x-input-address name="school_address" model="school.address" label="Alamat Sekolah" options="addressOptions"
        required wire:key="{{ \App\Helpers\Helper::key('input_address') }}"></x-input-address>

    <div class="layout-cols">
        <x-input-text type="phone" name="school_phone" model="school.phone" label="Telepon Sekolah"
            placeholder="xxx xxxx-xxxx" pattern="^\+(\d{1,3})\s?(\d{1,4})\s?(\d{1,4})\s?(\d{1,4})$"></x-input-text>
        <x-input-text type="phone" name="school_fax" model="school.fax" label="Fax. Sekolah"
            placeholder="xxx xxxx-xxxx" pattern="^\+(\d{1,3})\s?(\d{1,4})\s?(\d{1,4})\s?(\d{1,4})$"></x-input-text>
    </div>

    <x-input-text type="person" name="school_principal_name" model="school.principal_name" label="Nama Kepala Sekolah"
        placeholder="Masukkan nama kepala sekolah..." required></x-input-text>
</x-form>
