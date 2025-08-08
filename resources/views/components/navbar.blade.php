@props([
    'class' => null,
    'fixed' => false,
])

@php
    $fixedClass = $fixed ? 'fixed z-10 top-0 left-0' : 'block';
    $navbarClass = 'navbar justify-between gap-4 glass px-12 shadow-none';

    $class = implode(' ', array_values(array_filter([$navbarClass, $fixedClass, $class])));
@endphp

<nav class="{{ $class }}">
    <div class="flex gap-4 items-center">
        <x-brand></x-brand>
    </div>
</nav>
