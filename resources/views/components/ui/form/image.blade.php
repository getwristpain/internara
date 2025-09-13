@props([
    'name' => '',
    'field' => '',
    'preview' => '',
    'placeholder' => 'Unggah Berkas',
    'width' => 24,
    'height' => 24,
    'aspect' => 'square',
    'required' => false,
    'style' => [],
])

@php
    // Fallback default name
    $name = $name ?: str($field)->replace('.', '_')->snake()->toString();

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
@endphp

<div x-data="{
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
}" :class="@js(css('container'))" x-cloak {{ $attributes }}>
    <div class="group relative block h-fit w-full rounded-xl border p-4">
        <!-- Area Preview -->
        <div class="relative flex min-h-24 w-full items-center justify-center overflow-hidden">
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
            class="absolute left-0 top-0 h-full min-h-24 w-full p-2 opacity-0 transition duration-300 ease-in-out group-hover:opacity-95">
            <button
                class="glass !border-3 flex h-full w-full cursor-pointer items-center justify-center rounded-lg border-dashed !border-neutral-300 bg-neutral-100 text-center !shadow-none"
                x-on:click="$refs.imageInput.click()">
                {{-- Placeholder --}}
                <span
                    class="rounded-full border border-neutral-300 bg-neutral-100/50 px-4 py-2 font-bold text-neutral-500">
                    {{ $placeholder }}
                </span>
            </button>
        </div>

        <!-- Hidden input -->
        <input class="hidden" id="{{ $name }}" name="{{ $name }}" x-ref="imageInput" type="file"
            accept="image/*" wire:model="{{ $field }}" {{ $required ? 'required' : '' }}
            x-on:change="updatePreview" />
    </div>
</div>
