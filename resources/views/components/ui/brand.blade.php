@props([
    'url' => '/',
    'class' => '',
    'style' => [],
])

@php
    $url = empty($url) || $url === '#' ? $url : url($url);

    $style = [
        'base' => css('flex items-center gap-2 block w-auto h-4'),
        'brand' => [
            'logo' => css('aspect-square h-4 w-auto scale-110'),
            'name' => css('text-neutral truncate text-lg font-bold'),
        ],
    ];

    $class = css($class, $style['base']);
@endphp

<a href="{{ $url }}" wire:navigate tabindex="0">
    <div class="{{ $class }}">
        {{-- Brand Logo --}}
        <span>
            <img class="{{ $style['brand']['logo'] }}"
                src="{{ asset($shared->settings['brand_logo'] ?? config('app.logo')) }}" alt="Logo">
        </span>

        {{-- Brand Name --}}
        <span class="{{ $style['brand']['name'] }}">
            {{ $shared->settings['brand_name'] ?? config('app.name') }}
        </span>
    </div>
</a>
