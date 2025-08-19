@props([
    'brand' => setting('app_name', default: config('app.name')),
    'logo' => asset(setting('app_logo', default: config('app.logo'))),
    'class' => null,
])

@php
    $brandClass = 'flex items-center gap-2 block w-auto h-6';
    $class = implode(' ', array_values(array_filter([$brandClass, $class])));
@endphp

<a href="{{ url('/') }}" wire:navigate tabindex="0">
    <div class=" {{ $class }}">
        <img class="w-auto h-6 scale-110 aspect-square" src="{{ $logo }}" alt="Logo">
        <span class="font-bold text-neutral-700 text-xl">{{ $brand }}</span>
    </div>
</a>
