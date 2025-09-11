@props([
    'field' => '',
    'label' => null,
    'hint' => null,
    'required' => false,
    'class' => '',
    'style' => [],
])

@php
    // Normalisasi ID
    $id = str($field)->replace('.', '_')->snake()->toString();

    // Error state
    $hasErrors = $errors->has($field);

    // Wrapper style (unifikasi jadi 1 level)
    $style['component'] = [
        'container' => 'py-2 pl-1 flex items-center gap-2',
    ];

    // Input style
    $style['input'] = [
        'base' => 'checkbox checkbox-xs checkbox-neutral',
        'focus' => 'focus:outline-neutral',
        'error' => $hasErrors ? 'border-red-500 focus:outline-red-500' : '',
    ];

    // Format class strings
    $componentClass = trim($class . ' ' . implode(' ', array_values($style['component'])));
    $inputClass = trim(implode(' ', array_values($style['input'])));
@endphp

<div class="{{ $componentClass }}">
    <div class="flex items-center">
        <input class="{{ $inputClass }}" id="{{ $id }}" type="checkbox" wire:model="{{ $field }}"
            {{ $required ? 'required' : '' }} />

        @isset($label)
            <x-label for="{{ $id }}" :required="$required" :$hint>
                {{ $label }}
            </x-label>
        @endisset
    </div>

    @if ($hasErrors)
        <x-input.errors :$field />
    @endif
</div>
