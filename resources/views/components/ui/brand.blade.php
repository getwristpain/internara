@props([
    'attributes' => [],
    'url' => '/',
    'brand' => [
        'name' => $shared->settings['brand_name'],
        'logo' => $shared->settings['brand_logo'],
    ],
])

@php
    $url = empty($url) || $url === '#' ? $url : url($url);
@endphp

<a x-data x-cloak :class="@js(css('flex items-center gap-2 w-auto h-4'))" href="{{ $url }}" wire:navigate tabindex="0"
    {{ $attributes }}>
    {{-- Brand Logo --}}
    <span>
        <img class="aspect-square h-4 w-auto scale-110" src="{{ $brand['logo'] }}" alt="Logo">
    </span>

    {{-- Brand Name --}}
    <span class="text-neutral truncate text-lg font-bold">
        {{ $brand['name'] }}
    </span>
</a>
