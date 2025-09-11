@props([
    'attributes' => [],
    'name' => '',
    'field' => '',
    'label' => null,
    'hint' => null,
    'required' => false,
    'disabled' => false,
    'class' => '',
    'style' => [],
])

@php
    $hasErrors = $errors->has($field);

    $style = [
        'base' => css('py-2 pl-1 flex items-center gap-1 flex-nowrap'),
        'input' => css('checkbox checkbox-xs checkbox-neutral focus:outline-neutral', [
            'border-red-500 focus:outline-red-500' => $hasErrors,
        ]),
        'label' => css('truncate'),
    ];

    $class = css($class, $style['base']);
@endphp

<div class="{{ $class }}">
    <input class="{{ $style['input'] ?? '' }}" id="{{ $name }}" name="{{ $name }}" type="checkbox"
        wire:model.live="{{ $field }}"
        {{ $attributes->merge([
            'required' => $required,
            'disabled' => $disabled,
        ]) }} />

    @isset($label)
        <x-ui.label for="{{ $name }}" :$required :$hint>
            <span class="{{ $style['label'] ?? '' }}">
                {{ $label }}
            </span>
        </x-ui.label>
    @endisset
</div>
