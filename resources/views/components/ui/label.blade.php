@props([
    'hint' => null,
    'required' => '',
])

@php
    $required = $required ? 'required' : '';
@endphp

<label x-data :class="@js(css('label flex-wrap pl-2 gap-0 text-sm text-neutral-800'))" {{ $attributes }}>
    <div class="flex space-x-0">
        <span>{{ $slot }}</span>
        <span class="{{ $required }}"></span>
    </div>

    @isset($hint)
        <span class="text-wrap pl-1 text-neutral-600">({{ $hint }})</span>
    @endisset
</label>
