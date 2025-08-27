@props([
    'field' => '',
    'label' => null,
    'hint' => null,
    'required' => false,
])

@php
    $id = str(str_replace('.', ' ', $field))->camel()->toString();
    $hasErrors = $errors->has($field);
@endphp

<div class="py-2 pl-1">
    <div class="flex items-center">
        <input class="checkbox checkbox-xs checkbox-neutral focus:outline-neutral" id="{{ $id }}" type="checkbox"
            wire:model="{{ $field }}">

        @isset($label)
            <x-label for="{{ $id }}" :$required :$hint>{{ $label }}</x-label>
        @endisset
    </div>

    @if ($hasErrors)
        <x-input.errors :$field></x-input.errors>
    @endif
</div>
