@props([
    'disabled' => true,
    'field' => '',
    'hint' => null,
    'icon' => 'heroicons:chevron-up-down-16-solid',
    'label' => null,
    'options' => '',
    'placeholder' => 'Pilih...',
    'required' => true,
])

@php
    $id = str($field)->replace('.', ' ')->camel()->toString();
    $required = $required ? 'required' : '';

    $hasErrors = $errors->has($field);
@endphp

<div class="w-full py-2">
    <div class="flex flex-col gap-2 pt-1 w-full">
        {{-- Label --}}
        @isset($label)
            <x-label for="{{ $id }}" :$required :$hint>
                {{ $label }}
            </x-label>
        @endisset

        {{-- Select Wrapper --}}
        <div class="relative w-full min-w-full border rounded-full text-sm text-gray-500 {{ $hasErrors ? 'border-red-500 focus:outline-red-500' : 'border-neutral' }} {{ $disabled ? 'disabled' : '' }}"
            x-data="{
                open: false,
                options: @entangle($options),
                selected: @entangle($field).live
            }" x-on:click.away="open = false" tabindex="0">

            {{-- Display selected value / placeholder --}}
            <div class="flex items-center justify-between w-full pl-8 pr-3 py-2 cursor-pointer gap-2"
                x-on:click="open = !open">
                <span class="truncate"
                    x-text="selected && options && options[selected] ? options[selected] : '{{ $placeholder }}'"></span>

                <x-icon class="transition-transform duration-200" x-bind:class="{ 'rotate-180': open }"
                    icon="icon-park-solid:down-one" />
            </div>

            {{-- Left Icon --}}
            <x-icon class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm" icon="{{ $icon }}" />

            {{-- Hidden input for Livewire binding --}}
            <input class="hidden" id="{{ $id }}" type="text" wire:model="{{ $field }}"
                {{ $required }} disabled="{{ $disabled }}" />

            {{-- Dropdown --}}
            <div class="absolute left-0 top-full mt-2 w-full z-10" x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                style="display: none;">

                <div class="glass bg-gray-50 rounded-xl !border !border-neutral w-full p-2">
                    <template x-for="(text, value) in options" :key="value" x-if="options.length > 0">
                        <div class="px-3 py-2 rounded-lg hover:outline outline-neutral cursor-pointer transition ease-in-out duration-300"
                            x-on:click="selected = value; open = false" x-text="text"></div>
                    </template>

                    <template x-if="options.length === 0">
                        <div class="px-3 py-2 text-gray-500">Tidak ada opsi tersedia</div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Error message --}}
        @if ($hasErrors)
            @include('partials.input.input-errors')
        @endif
    </div>
</div>
