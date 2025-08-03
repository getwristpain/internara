@props([
    'brand' => setting('app_name', default: config('app.name')),
    'logo' => asset(setting('app_logo', default: config('app.logo'))),
    'height' => 6,
])

@php
    $height -= 3;
    $brandClass = "flex items-center gap-2 block w-auto h-full max-h-{$height}";
@endphp

<a href="{{ url('/') }}">
    <div {{ $attributes->merge(['class' => $brandClass]) }}>
        <img class="w-auto h-{{ $height }} min-h-4 aspect-square" src="{{ $logo }}" alt="Logo">
        <span class="font-bold text-neutral-700">{{ $brand }}</span>
    </div>
</a>
