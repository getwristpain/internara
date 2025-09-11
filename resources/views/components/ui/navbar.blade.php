@props([
    'home_url' => '/',
    'type' => 'glass',
    'fixed' => false,
    'class' => '',
    'style' => [],
])

@php
    $style = [
        'base' => css('navbar px-4 md:px-8 lg:px-12 w-full', [
            'fixed z-10 top-0 left-0' => $fixed,
            'glass shadow-none' => $type === 'glass',
        ]),
        'content' => css('container mx-auto'),
        'menu' => css('flex items-center justify-between gap-4'),
    ];

    $class = css($class, $style['base']);
@endphp

<nav class="{{ $class }}">
    {{-- Content --}}
    <div class="{{ $style['content'] }}">
        {{-- Brand --}}
        <x-ui.brand url="{{ $home_url }}" />
        {{-- Menu --}}
        <div class="{{ $style['menu'] }}">
            {{ $slot }}
        </div>
    </div>
</nav>
