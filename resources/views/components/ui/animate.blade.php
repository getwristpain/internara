@props([
    'type' => 'fade-in',
])

@php
    $type = in_array($type, ['fade-in-out', 'fade-in', 'fade-out']) ? $type : 'fade-in';
    $component = "ui.animate.{$type}";
@endphp

<x-dynamic-component component="{{ $component }}" {{ $attributes }}>
    {{ $slot }}
</x-dynamic-component>
