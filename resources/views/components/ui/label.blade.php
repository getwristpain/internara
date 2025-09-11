@props([
    'class' => null,
    'for' => null,
    'hint' => null,
    'required' => '',
    'style' => [],
])

@php
    $labelClass = 'label flex-wrap pl-2 gap-0 text-sm text-neutral-800';
    $class = implode(' ', array_values(array_filter([$labelClass, $class])));

    $style['required'] = $required ? 'required' : '';
@endphp

<label class="{{ $class }}" for="{{ $for }}">
    <div class="flex space-x-0">
        <span>{{ $slot }}</span>
        <span class="{{ $style['required'] }}"></span>
    </div>

    @isset($hint)
        <span class="text-wrap pl-1 text-neutral-600">({{ $hint }})</span>
    @endisset
</label>
