@props([
    'name' => '',
    'label' => '',
    'hint' => '',
    'required' => false,
    'disabled' => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2 ' . (!$disabled ?: 'disabled')]) }}">
    <x-input-label :$name :$label :$required :$hint></x-input-label>

    <div class="w-full p-4 space-y-4 border border-gray-300 rounded-lg min-h-12" id="{{ $name }}">
        {{ $slot }}
    </div>
</div>
