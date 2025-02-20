@props([
    'options' => '',
    'disabled' => false,
    'help' => '',
    'label' => '',
    'model' => '',
    'name' => '',
    'required' => false,
])

<div class="w-full space-y-2">
    @if ($label)
        <label class="{{ $required ? 'required' : '' }} {{ $disabled ? 'disabled opacity-100' : '' }}">
            <span>{{ $label }}</span>
            @if ($help)
                <span class="pl-1 text-gray-500">({{ $help }})</span>
            @endif
        </label>
    @endif

    <div class="space-y-4">
        <div class="layout-cols">
            <x-input-select wire:key="{{ \App\Helpers\Helper::key('input_select_province') }}"
                name="{{ $name . '_province' }}" model="{{ $model . '.province_id' }}"
                options="{{ $options . '.provinces' }}" placeholder="Provinsi" :$required searchbar></x-input-select>
            <x-input-select wire:key="{{ \App\Helpers\Helper::key('input_select_regency') }}"
                name="{{ $name . '_regency' }}" model="{{ $model . '.regency_id' }}"
                options="{{ $options . '.regencies' }}" placeholder="Kabupaten/Kota" :$required
                searchbar></x-input-select>
            <x-input-select wire:key="{{ \App\Helpers\Helper::key('input_select_district') }}"
                name="{{ $name . '_district' }}" model="{{ $model . '.district_id' }}"
                options="{{ $options . '.districts' }}" placeholder="Kecamatan" :$required searchbar></x-input-select>
        </div>

        <div class="items-center layout-cols">
            <x-input-select wire:key="{{ \App\Helpers\Helper::key('input_select_village') }}"
                name="{{ $name . '_village' }}" model="{{ $model . '.village_id' }}"
                options="{{ $options . '.villages' }}" placeholder="Desa/Kelurahan" :$required
                searchbar></x-input-select>
            <div class="flex w-full gap-4">
                <div class="flex-1">
                    <x-input-text wire:key="{{ \App\Helpers\Helper::key('input_text_street') }}" type="text"
                        name="{{ $name . '_street' }}" model="{{ $model . '.street' }}"
                        placeholder="RT/RW/Nama Jalan/Nomor Bangunan (Opsional)"></x-input-text>
                </div>
                <div class="w-1/3">
                    <x-input-text wire:key="{{ \App\Helpers\Helper::key('input_text_postal_code') }}" type="number"
                        name="{{ $name . '_postal_code' }}" model="{{ $model . '.postal_code' }}"
                        placeholder="Kode Pos" :$required></x-input-text>
                </div>
            </div>
        </div>
    </div>
</div>
