@props([
    'attributes' => [],
    'home_url' => '/',
    'type' => 'glassy',
    'fixed' => false,
    'class' => '',
])

@php
    $class = css(
        'navbar px-4 lg:px-8 w-full',
        [
            'fixed z-10 top-0 left-0' => $fixed,
            'glass shadow-none' => $type === 'glassy',
        ],
        $class,
    );
@endphp

<nav class="{{ $class }}" {{ $attributes }}>
    {{-- Content --}}
    <div class="container mx-auto">
        {{-- Brand --}}
        <x-ui.brand url="{{ $home_url }}" />
        {{-- Menu --}}
        <div class="flex items-center justify-between gap-4">
            {{ $slot }}
        </div>
    </div>
</nav>
