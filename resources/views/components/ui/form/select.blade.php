@props([
    'field' => '',
    'name' => '',
    'options' => '',
    'placeholder' => 'Pilih...',
    'required' => true,
    'disabled' => false,
    'icon' => 'heroicons:chevron-up-down-16-solid',
    'class' => '',
    'style' => [],
])

@php
    // Fallback default name
    $name = $name ?: str($field)->replace('.', '_')->snake()->toString();

    // Error state
    $hasErrors = $errors->has($field);

    // Wrapper style
    $style['component'] = [
        'container' => 'relative w-full min-w-full rounded-xl border text-sm',
        'error' => $hasErrors ? 'border-red-500 focus:outline-red-500' : 'border-neutral',
        'disabled' => $disabled ? 'disabled opacity-70 cursor-not-allowed' : '',
    ];

    // Input style (hidden input untuk binding Livewire)
    $style['input'] = [
        'hidden' => 'hidden',
    ];

    // Finalize class strings
    $componentClass = trim($class . ' ' . implode(' ', array_values($style['component'])));
    $inputClass = implode(' ', array_values($style['input']));
@endphp

<div class="{{ $componentClass }}" x-data="{
    open: false,
    options: @entangle($options),
    selected: @entangle($field)
}" x-on:click.away="open = false" tabindex="0">

    {{-- Display selected value / placeholder --}}
    <div class="flex w-full cursor-pointer items-center justify-between gap-2 py-2 pl-8 pr-3" x-on:click="open = !open">
        <span class="truncate" x-bind:class="{ 'text-neutral': selected }"
            x-text="selected && options && options[selected] ? options[selected] : '{{ $placeholder }}'">
        </span>

        <iconify-icon class="z-2 transition-transform duration-200" x-bind:class="{ 'rotate-180': open }"
            icon="icon-park-solid:down-one">
        </iconify-icon>
    </div>

    {{-- Left Icon --}}
    <iconify-icon class="z-2 absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400" icon="{{ $icon }}">
    </iconify-icon>

    {{-- Hidden input for Livewire binding --}}
    <input class="{{ $inputClass }}" id="{{ $name }}" name="{{ $name }}" type="text"
        x-model="selected" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} />

    {{-- Dropdown --}}
    <div class="absolute left-0 top-full z-10 mt-2 w-full" x-show="open"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
        style="display: none;">

        <div class="glass !border-neutral w-full rounded-xl !border bg-gray-50/10 p-2">
            <template x-for="(text, value) in options" :key="value" x-if="options.length > 0">
                <div class="outline-neutral cursor-pointer rounded-lg px-3 py-2 transition duration-300 ease-in-out hover:outline"
                    x-on:click="selected = value; open = false" x-text="text">
                </div>
            </template>

            <template x-if="options.length === 0">
                <div class="px-3 py-2 text-gray-500">Tidak ada opsi tersedia</div>
            </template>
        </div>
    </div>
</div>
