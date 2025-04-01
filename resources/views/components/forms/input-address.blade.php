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

    <x-forms.input-label :$name :$label :$required :$hint />

    <div class="space-y-4">
        <div class="items-center layout-cols">
            <x-forms.input-select class="w-full" wire:key="{{ \App\Helpers\Helper::key('input_select_province') }}"
                name="{{ $name . '_province' }}" model="{{ $model . '.province_id' }}"
                options="{{ $options . '.provinces' }}" placeholder="Provinsi" :$required searchbar />

            <x-forms.input-select class="w-full" wire:key="{{ \App\Helpers\Helper::key('input_select_regency') }}"
                name="{{ $name . '_regency' }}" model="{{ $model . '.regency_id' }}"
                options="{{ $options . '.regencies' }}" placeholder="Kabupaten/Kota" :$required searchbar />

            <x-forms.input-select class="w-full" wire:key="{{ \App\Helpers\Helper::key('input_select_district') }}"
                name="{{ $name . '_district' }}" model="{{ $model . '.district_id' }}"
                options="{{ $options . '.districts' }}" placeholder="Kecamatan" :$required searchbar />
        </div>

        <div class="items-center layout-cols">
            <x-forms.input-select class="w-full" wire:key="{{ \App\Helpers\Helper::key('input_select_subdistrict') }}"
                name="{{ $name . '_subdistrict' }}" model="{{ $model . '.subdistrict_id' }}"
                options="{{ $options . '.subdistricts' }}" placeholder="Desa/Kelurahan" :$required searchbar />

            <x-forms.input-text class="w-full" wire:key="{{ \App\Helpers\Helper::key('input_text_street') }}"
                type="text" name="{{ $name . '_street' }}" model="{{ $model . '.street' }}"
                placeholder="RT/RW/Nama Jalan/Nomor Bangunan (Opsional)" />

            <x-forms.input-text class="max-w-40" wire:key="{{ \App\Helpers\Helper::key('input_text_postal_code') }}"
                name="{{ $name . '_postal_code' }}" model="{{ $model . '.postal_code' }}" placeholder="Kode Pos"
                :$required />
        </div>
    </div>
</div>
