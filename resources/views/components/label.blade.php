@props([
    'class' => null,
    'for' => null,
    'hint' => null,
    'required' => '',
])

@php
    $labelClass = 'label flex-wrap pl-2 gap-0 text-sm text-neutral-800';
    $class = implode(' ', array_values(array_filter([$labelClass, $class])));
@endphp

<label class="{{ $class }}" for="{{ $for }}">
    <div class="flex space-x-0">
        <span>{{ $slot }}</span>
        <span class="{{ $required }}"></span>
    </div>

    @isset($hint)
        <span class="text-neutral-600 pl-1 text-wrap">({{ $hint }})</span>
    @endisset
</label>
