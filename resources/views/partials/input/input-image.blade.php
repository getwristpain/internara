@props([
    'class' => null,
    'aspect' => 'square',
    'placeholder' => 'Unggah Berkas',
    'label' => null,
    'required' => false,
    'hint' => null,
    'preview' => null,
    'field' => '',
    'size' => 'w-24 h-24',
])

@php
    $id = str(str_replace('.', ' ', $field))->camel()->toString();
    $required = $required ? 'required' : '';

    $hasErrors = $errors->has($field);

    $aspectClass = 'aspect-' . $aspect;
    $sizeClass = $size . ' ' . $aspectClass;
    $componentClass = 'w-full h-fit py-2 space-y-2';
    $class = implode(' ', array_values(array_filter([$componentClass, $class])));
@endphp

<div class="{{ $class }}">
    <div>
        <x-label :$required :$hint>{{ $label }}</x-label>
    </div>

    <div class="border rounded-xl w-full min-h-24 p-4 group {{ $hasErrors ? 'border-red-500' : 'border-neutral' }}"
        x-data="{
            imagePreview: @js($preview),
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
        <div class="relative block w-full h-fit">
            <div class="relative flex items-center justify-center overflow-hidden rounded-xl min-h-24 w-full p-2"
                x-cloak>
                <!-- Preview image -->
                <template x-if="imagePreview">
                    <div class="rounded-xl {{ $sizeClass }}">
                        <img class="object-cover rounded-xl w-full h-full" :src="imagePreview" alt="Preview" />
                    </div>
                </template>

                <!-- Default SVG -->
                <template x-if="!imagePreview">
                    <x-no-image :$size></x-no-image>
                </template>
            </div>

            <!-- Overlay label trigger -->
            <label
                class="absolute top-0 left-0 opacity-0 glass w-full h-full min-h-24 p-4 text-center flex justify-center items-center shadow-none !border-3 border-dashed border-neutral-400 rounded-lg transition duration-300 ease-in-out group-hover:opacity-95 group-hover:bg-neutral-200 cursor-pointer"
                for="{{ $id }}">
                <span class="font-bold text-neutral-500">{{ $placeholder }}</span>
            </label>

            <!-- Hidden input -->
            <input class="hidden" id="{{ $id }}" type="file" accept="image/*"
                wire:model="{{ $field }}" x-on:change="updatePreview" />
        </div>
    </div>

    @if ($errors->has($field))
        <div class="flex flex-col pt-1 w-full">
            @foreach ($errors->get($field) as $error)
                <span class="text-error font-semibold text-sm">{{ $error }}</span>
            @endforeach
        </div>
    @endif
</div>
