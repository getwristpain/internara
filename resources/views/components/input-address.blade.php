@props([
    'options' => '',
    'disabled' => false,
    'hint' => null,
    'label' => null,
    'model' => '',
    'name' => '',
    'required' => false,
])

<div class="w-full space-y-2 {{ $disabled ? 'disabled' : '' }}" wire:loading.class="disabled"
    wire:target="{{ $options }}">

    <x-label :$name :$label :$required :$hint />

    <div class="space-y-4">
        <div class="items-center layout-cols">
            <x-input-select class="w-full" name="{{ $name . '_province' }}" model="{{ $model . '.province_id' }}"
                options="{{ $options . '.provinces' }}" placeholder="Provinsi" :$required searchbar :key="\App\Helpers\Helper::key($name . '_province')" />

            <x-input-select class="w-full" name="{{ $name . '_regency' }}" model="{{ $model . '.regency_id' }}"
                options="{{ $options . '.regencies' }}" placeholder="Kabupaten/Kota" :$required searchbar
                :key="\App\Helpers\Helper::key($name . '_regency')" />

            <x-input-select class="w-full" name="{{ $name . '_district' }}" model="{{ $model . '.district_id' }}"
                options="{{ $options . '.districts' }}" placeholder="Kecamatan" :$required searchbar
                :key="\App\Helpers\Helper::key($name . '_distric')" />
        </div>

        <div class="items-center layout-cols">
            <x-input-select class="w-full" name="{{ $name . '_subdistrict' }}"
                model="{{ $model . '.subdistrict_id' }}" options="{{ $options . '.subdistricts' }}"
                placeholder="Desa/Kelurahan" :$required searchbar :key="\App\Helpers\Helper::key($name . '_subdistric')" />

            <div class="flex items-center w-full gap-4">
                <x-input-text class="w-full" type="text" name="{{ $name . '_street' }}"
                    model="{{ $model . '.street' }}" placeholder="RT/RW/Nama Jalan/Nomor Bangunan (Opsional)"
                    :key="\App\Helpers\Helper::key($name . '_street')" />

                <x-input-text class="max-w-40" name="{{ $name . '_postal_code' }}"
                    model="{{ $model . '.postal_code' }}" placeholder="Kode Pos" :$required :key="\App\Helpers\Helper::key($name . '_postal_code')" />
            </div>
        </div>
    </div>
</div>
