@props([
    'component' => [],
    'hideMessages' => false,
    'name' => '',
    'label' => '',
    'messages' => [],
    'model' => '',
    'placeholder' => 'Unggah Berkas',
    'required' => false,
])

@php
    $componentHasErrorsStyles = !empty($messages) ? 'border-red-500' : 'border-gray-300';
    $componentStyles = implode(' ', [$componentHasErrorsStyles, $component['styles'] ?? '']);
    $inputStyles = implode(' ', [$componentHasErrorsStyles, $component['inputStyles'] ?? '']);

    $messages = !empty($messages) ? $message : ($errors->has($model) ? $errors->get($model) : []);
@endphp

<div x-data="{
    preview: @entangle($model).live,
    selectFile() {
        this.$refs.fileInput.click();
    },
    updatePreview(event) {
        const file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.preview = e.target.result;
                $wire.set('{{ $model }}', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }
}" {{ $attributes->merge(['class' => 'space-y-2 font-medium']) }} x-cloak>
    @if (isset($label))
        <label class="{{ !$required ?: 'required' }}" for="{{ $name }}">{{ $label }}</label>
    @endif

    <div
        class="flex flex-col items-center justify-center w-full gap-2 border rounded-lg min-h-4 p-4 {{ $componentStyles }}">
        <!-- Hidden File Input -->
        <input class="hidden" id="{{ $name }}" name="{{ $name }}" {{ $required }} type="file"
            x-ref="fileInput" @change="updatePreview" wire:model="{{ $model }}">

        <div class="cursor-pointer hover:bg-gray-200 basic-transition border-4 border-dashed rounded-lg bg-gray-100 p-4 {{ $inputStyles }}"
            @click="selectFile">
            <div>
                <template x-if="preview">
                    <img class="object-cover h-24" :src="preview" alt="{{ $label }}">
                </template>
                <template x-if="!preview">
                    <x-no-media class="h-24 opacity-40"></x-no-media>
                </template>
            </div>
        </div>

        @if (!empty($messages) && !$hideMessages)
            <div>
                <x-input-error :$messages></x-input-error>
            </div>
        @endif
    </div>
</div>
