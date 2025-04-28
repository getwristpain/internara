@props([
    'attributes' => [],
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'label' => null,
    'messages' => [],
    'model' => '',
    'name' => '',
    'placeholder' => 'Unggah Berkas',
    'required' => false,
    'preview' => null,
])

@php
    $messages = !empty($messages) ? $messages : (!empty($model) && $errors->has($model) ? $errors->get($model) : []);
    $hasErrors = !empty($messages);
    $borderColor = $hasErrors ? 'border-red-500' : 'border-gray-300';
@endphp

<div class="space-y-2 font-medium" x-data="{
    preview: null,
    initImage: @entangle($preview) ?? @entangle($model),
    init() {
        if (!this.preview && this.initImage) {
            this.preview = this.initImage;
        }
    },
    updatePreview(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = (e) => this.preview = e.target.result;
            reader.readAsDataURL(file);
        }
    }
}">
    <x-label :name="$name" :label="$label" :required="$required" :hint="$hint" />

    <div {{ $attributes->merge([
        'class' => implode(' ', [
            'flex flex-col items-center justify-center w-full gap-2 border rounded-lg min-h-4 p-4',
            $borderColor,
            $disabled ? ' disabled' : '',
        ]),
        'disabled' => 'disabled',
    ]) }}
        wire:loading.class="loading-disabled" wire:target="{{ $model }}">

        <!-- Hidden File Input -->
        <input
            {{ $attributes->merge([
                'class' => 'hidden ' . ($disabled ? 'disabled' : ''),
                'disabled' => $disabled,
                'id' => $name,
                'name' => $name,
                'type' => 'file',
            ]) }}
            wire:model="{{ $model }}" x-ref="fileInput" @change="updatePreview($event)">

        <!-- Drop Area -->
        <div class="basic-transition bg-gray-100 border-4 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-300 relative"
            @click="$refs.fileInput.click()">
            <div class="wh-full p-4">
                <template x-if="preview">
                    <img class="object-cover h-24" :src="preview" alt="{{ $label }}">
                </template>
                <template x-if="!preview">
                    <x-no-media class="h-24 opacity-40"></x-no-media>
                </template>
            </div>

            <div class="absolute top-0 isset-0 wh-full bg-white bg-opacity-75" wire:loading
                wire:target="{{ $model }}">
                <div class="flex items-center justify-center gap-2 wh-full">
                    <span class="loading loading-spinner"></span>
                </div>
            </div>
        </div>

        @if ($hasErrors && !$hideMessages)
            <div>
                <x-input-error :messages="$messages"></x-input-error>
            </div>
        @endif
    </div>
</div>
