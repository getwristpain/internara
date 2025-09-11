@props([
    'name' => '',
    'field' => '',
    'preview' => '',
    'placeholder' => 'Unggah Berkas',
    'required' => false,
    'class' => '',
    'width' => 24,
    'height' => 24,
    'aspect' => 'square',
    'style' => [],
])

@php
    // Konversi ukuran
    $width = (string) $width;
    $height = (string) $height;

    // Error state
    $hasErrors = $errors->has($field);

    $style = [
        'base' => 'container',
        'preview' => css(' rounded-xl', "aspect-{$aspect}", "w-{$width} h-{$height}"),
        'size' => css("w-{$width} h-{$height}"),
    ];

    $class = css($class, $style['base']);
@endphp

<div class="{{ $class }}" x-data="{
    imagePreview: @entangle($preview).live,
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

    <div class="group relative block h-fit w-full rounded-xl border p-4">
        <!-- Area Preview -->
        <div class="relative flex min-h-24 w-full items-center justify-center overflow-hidden" x-cloak>
            <!-- Jika ada preview -->
            <template x-if="imagePreview">
                <div class="{{ $style['preview'] ?? '' }}">
                    <img class="h-full w-full rounded-xl object-cover" :src="imagePreview" alt="Preview" />
                </div>
            </template>

            <!-- Jika tidak ada preview -->
            <template x-if="!imagePreview">
                <x-ui.no-image size="{{ $style['size'] }}" />
            </template>
        </div>

        <!-- Overlay trigger -->
        <div
            class="absolute left-0 top-0 h-full min-h-24 w-full p-4 opacity-0 transition duration-300 ease-in-out group-hover:opacity-95">
            <label
                class="glass !border-3 flex h-full w-full cursor-pointer items-center justify-center rounded-lg border-dashed !border-neutral-400 bg-neutral-200 text-center !shadow-none"
                for="{{ $name }}">
                <span class="font-bold text-neutral-500">{{ $placeholder }}</span>
            </label>
        </div>

        <!-- Hidden input -->
        <input class="hidden" id="{{ $name }}" name="{{ $name }}" type="file" accept="image/*"
            wire:model.live="{{ $field }}" {{ $required ? 'required' : '' }} x-on:change="updatePreview" />
    </div>
</div>
