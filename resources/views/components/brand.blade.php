@props([
    'name' => setting()->cached('app_name', default: config('app.name')),
    'logo' => asset(setting()->cached('app_logo', default: config('app.logo'))),
    'class' => '',
    'style' => [],
])

@php
    $style['brand'] = 'flex items-center gap-2 block w-auto h-4';

    $class .= ' ' . implode(' ', array_values($style));
@endphp

<a href="{{ url('/') }}" wire:navigate tabindex="0">
    <div class=" {{ $class }}">
        <img class="w-auto h-4 scale-110 aspect-square" src="{{ $logo }}" alt="Logo">
        <span class="font-bold text-lg text-neutral truncate">{{ $name }}</span>
    </div>
</a>
