@props([
    'name' => setting()->cached('brand_name', default: config('app.name')),
    'logo' => asset(setting()->cached('brand_logo', default: config('app.logo'))),
    'class' => '',
    'style' => [],
])

@php
    $style['brand'] = 'flex items-center gap-2 block w-auto h-4';

    $class .= ' ' . implode(' ', array_values($style));
@endphp

<a href="{{ url('/') }}" wire:navigate tabindex="0">
    <div class="{{ $class }}">
        <img class="aspect-square h-4 w-auto scale-110" src="{{ $logo }}"
            alt="Logo">
        <span
            class="text-neutral truncate text-lg font-bold">{{ $name }}</span>
    </div>
</a>
