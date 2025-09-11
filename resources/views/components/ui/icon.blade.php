@props([
    'icon' => '',
    'class' => '',
    'style' => [],
])

@php
    $isIconify = count(explode(':', $icon)) >= 2;

    $style = [
        'icon' => [
            'base' => 'flex aspect-square items-center justify-center',
        ],
    ];

    $class = trim($class . ' ' . implode(' ', array_values($style['icon'])));
@endphp

<span class="{{ $icon }}">
    @if ($isIconify)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @else
        <x-icon class="icon-md" name="{{ $icon }}"></x-icon>
    @endif
</span>
