@props([
    'class' => null,
    'for' => null,
    'hint' => null,
    'required' => '',
])

@php
    $labelClass = 'label pl-2 space-x-0 gap-0 text-sm';
    $class = implode(' ', array_values(array_filter([$labelClass, $class])));
@endphp

<label class="{{ $class }}" for="{{ $for }}">
    <span>{{ $slot }}</span>
    <span class="{{ $required }}"></span>

    @isset($hint)
        <span class="text-gray-500 pl-1">({{ $hint }})</span>
    @endisset
</label>
