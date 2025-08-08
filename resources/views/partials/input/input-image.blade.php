@props([
    'class' => null,
    'aspect' => 'square',
    'placeholder' => 'Unggah Berkas',
    'label' => null,
    'required' => false,
    'hint' => null,
    'preview' => '',
    'field' => '',
    'height' => '24',
])

@php
    $id = str(str_replace('.', ' ', $field))->camel()->toString();
    $required = $required ? 'required' : '';

    $height = 'h-' . $height;
    $aspect = 'aspect-' . $aspect;
    $component = 'wh-full space-y-2 py-3';
    $class = implode(' ', array_values(array_filter([$component, $class])));
@endphp

<div class="{{ $class }}">
    <div>
        <x-label :$required :$hint>{{ $label }}</x-label>
    </div>

    <div class="border border-neutral rounded-xl w-full min-h-24 p-4 group" x-data="{
        imagePreview: '{{ $preview }}',
        updatePreview(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.imagePreview = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }">
        <div class="relative block wh-full">
            <div class="flex wh-full min-h-24 items-center justify-center overflow-hidden rounded-xl">
                <!-- Preview image -->
                <template x-if="imagePreview">
                    <div class="w-auto {{ $height }} {{ $aspect }}">
                        <img class="object-cover w-full h-full rounded-xl" :src="imagePreview" alt="Preview">
                    </div>
                </template>

                <!-- Default SVG -->
                <template x-if="!imagePreview">
                    <svg class="w-24 h-24 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="0.8">
                            <path
                                d="M16.24 3.5h-8.5a5 5 0 0 0-5 5v7a5 5 0 0 0 5 5h8.5a5 5 0 0 0 5-5v-7a5 5 0 0 0-5-5" />
                            <path
                                d="m2.99 17l2.75-3.2a2.2 2.2 0 0 1 2.77-.27a2.2 2.2 0 0 0 2.77-.27l2.33-2.33a4 4 0 0 1 5.16-.43l2.49 1.93M7.99 10.17a1.66 1.66 0 1 0 0-3.32a1.66 1.66 0 0 0 0 3.32" />
                        </g>
                    </svg>
                </template>
            </div>

            <!-- Overlay label trigger -->
            <label
                class="absolute top-0 left-0 opacity-0 group-hover:opacity-100 glass w-full h-full min-h-24 p-4 text-center flex justify-center items-center font-medium text-sm shadow-none !border-3 border-dashed border-neutral-400 rounded-lg text-neutral-500 transition duration-300 ease-in-out hover:bg-neutral-200"
                for="{{ $id }}">
                <span>{{ $placeholder }}</span>
            </label>

            <!-- Hidden input -->
            <input class="hidden" id="{{ $id }}" type="file" accept="image/*"
                wire:model="{{ $field }}" x-on:change="updatePreview" />
        </div>
    </div>
</div>
