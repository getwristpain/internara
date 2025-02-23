@props([
    'hideMessages' => false,
    'hint' => null,
    'label' => null,
    'messages' => [],
    'model' => '',
    'name' => '',
    'placeholder' => 'Unggah Berkas',
    'required' => false,
    'value' => '',
])

@php
    $messages = !empty($messages) ? $messages : (!empty($model) && $errors->has($model) ? $errors->get($model) : []);
    $hasErrors = !empty($messages);
    $borderColor = $hasErrors ? 'border-red-500' : 'border-gray-300';
@endphp

<div class="space-y-2 font-medium" x-data="{
    preview: null,
    initImage: @js($value) ?? @entangle($model),
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
    <x-input-label :name="$name" :label="$label" :required="$required" :hint="$hint"></x-input-label>

    <div
        class="flex flex-col items-center justify-center w-full gap-2 border rounded-lg min-h-4 p-4 {{ $borderColor }}">

        <!-- Hidden File Input -->
        <input class="hidden" id="{{ $name }}" type="file" name="{{ $name }}"
            wire:model="{{ $model }}" x-ref="fileInput" @change="updatePreview($event)">

        <!-- Drop Area -->
        <div class="cursor-pointer hover:bg-gray-200 transition border-4 border-dashed rounded-lg bg-gray-100 p-4"
            @click="$refs.fileInput.click()">
            <div>
                <template x-if="preview">
                    <img class="object-cover h-24" :src="preview" :alt="preview">
                </template>
                <template x-if="!preview">
                    <x-no-media class="h-24 opacity-40"></x-no-media>
                </template>
            </div>
        </div>

        @if ($hasErrors && !$hideMessages)
            <div>
                <x-input-error :messages="$messages"></x-input-error>
            </div>
        @endif
    </div>
</div>
