@props([
    'class' => '',
    'label' => null,
    'for' => null,
    'hint' => null,
    'required' => false,
    'bordered' => false,
    'style' => [],
])

@php
    $for = str($for)->replace('.', ' ')->camel()->toString() ?? str(trim($label))->camel()->toString();

    $style['group'] = $bordered ? 'border border-neutral-900 p-4' : '';
    $style['component'] = 'pt-2';

    $class .= ' ' . $style['component'];
@endphp

<div class="{{ $class }}" {{ $attributes }}>
    @isset($label)
        <x-label class="{{ $style['label'] ?? '' }}" :$for :$required :$hint>
            {{ $label }}
        </x-label>
    @endisset

    <div class="{{ $style['group'] ?? '' }} group w-full rounded-xl">
        {{ $slot }}
    </div>
</div>
