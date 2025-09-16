@props([
    'type' => 'info',
    'message' => '',
    'position' => 'block',
    'class' => '',
    'pulse' => false,
    'modify' => [],
])

@php
    $modify = [
        'base' => css('z-20 glass rounded-xl px-8 py-2 font-medium', ['animate-pulse' => $pulse]),
        'position' => css(
            match ($position) {
                'fixed-tc' => 'fixed top-8 left-1/2 -translate-x-1/2',
                'fixed-bl' => 'fixed bottom-8 left-8',
                'fixed-br' => 'fixed bottom-8 right-8',
                default => '',
            },
        ),
        'color' => css(
            match ($type) {
                'info' => 'bg-blue-200 text-blue-700',
                default => 'bg-neutral-50',
            },
        ),
    ];

    $class = css($class, array_values($modify));
@endphp

<div class="{{ $class }}" {{ $attributes }}>
    <span>{{ $message }}</span>
</div>
