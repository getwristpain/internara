@props([
    'class' => 'min-w-24 min-h-24 aspect-square text-neutral-300',
    'size' => 'w-24 h-24',
])

@php
    $sizeClass = $size . ' aspect-square';
    $class = implode(' ', [$sizeClass, $class]);
@endphp

<svg class="{{ $class }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8">
        <path d="M16.24 3.5h-8.5a5 5 0 0 0-5 5v7a5 5 0 0 0 5 5h8.5a5 5 0 0 0 5-5v-7a5 5 0 0 0-5-5" />
        <path
            d="m2.99 17l2.75-3.2a2.2 2.2 0 0 1 2.77-.27a2.2 2.2 0 0 0 2.77-.27l2.33-2.33a4 4 0 0 1 5.16-.43l2.49 1.93M7.99 10.17a1.66 1.66 0 1 0 0-3.32a1.66 1.66 0 0 0 0 3.32" />
    </g>
</svg>
