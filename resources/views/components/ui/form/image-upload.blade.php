@props([
    'name' => '',
    'field' => '',
    'preview' => '',
    'placeholder' => 'Unggah Berkas',
    'width' => 24,
    'height' => 24,
    'aspect' => 'square',
    'required' => false,
    'disabled' => false,
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
                <div class="{{ $style['preview'] ?? '' }}" wire:target="{{ $field }}"
                    wire:loading.class="opacity-0">
                    <img class="h-full w-full rounded-xl object-cover" :src="imagePreview" alt="Preview" />
                </div>
            </template>

            <!-- Jika tidak ada preview -->
            <template x-if="!imagePreview">
                <x-ui.no-image size="{{ $style['size'] }}" wire:target="{{ $field }}"
                    wire:loading.class="opacity-0" />
            </template>

            {{-- Placeholder Loading Effect --}}
            <span class="animate-move-x {{ $style['preview'] }} absolute block bg-neutral-500"
                wire:target="{{ $field }}" wire:loading></span>
        </div>

        <!-- Overlay trigger -->
        <div class="glass absolute left-0 top-0 h-full min-h-24 w-full rounded-xl p-2 opacity-0 transition duration-300 ease-in-out group-hover:opacity-95"
            wire:target="{{ $field }}" wire:loading.class="hidden">
            <div class="glass !border-3 flex h-full w-full cursor-pointer items-center justify-center rounded-xl border-dashed !border-neutral-300 bg-white text-center !shadow-none"
                x-on:click="$refs.imageInput.click()">
                {{-- Placeholder --}}
                <span class="truncate rounded-full border bg-neutral-900 px-8 py-2 font-medium text-neutral-100">
                    {{ $placeholder }}
                </span>
            </div>
        </div>

        <!-- Uploading -->
        <div class="glass z-2 absolute left-0 top-0 h-full min-h-24 w-full rounded-xl p-2"
            wire:target="{{ $field }}" wire:loading>
            <div
                class="glass flex h-full w-full items-center justify-center rounded-xl bg-gradient-to-br from-white to-neutral-50 text-center">
                <span
                    class="animate-pulse truncate rounded-full border border-neutral-300 bg-white px-8 py-2 font-medium text-neutral-700">
                    Uploading...
                </span>
            </div>
        </div>

        <!-- Hidden input -->
        <input class="hidden" id="{{ $name }}" name="{{ $name }}" x-ref="imageInput" type="file"
            accept="image/*" wire:model="{{ $field }}" {{ $disabled ? 'disabled' : '' }}
            x-on:change="updatePreview" wire:target="{{ $field }}" wire:loading.attr="disabled" />
    </div>
</div>
