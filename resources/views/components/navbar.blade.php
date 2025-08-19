@props([
    'class' => null,
    'fixed' => false,
])

@php
    $fixedClass = $fixed ? 'fixed z-10 top-0 left-0' : 'block';
    $navbarClass = 'navbar glass shadow-none';

    $class = implode(' ', array_values(array_filter([$navbarClass, $fixedClass, $class])));
@endphp

<nav class="{{ $class }}">
    <div class="container mx-auto px-4 md:px-8 lg:px-12 w-full h-full">
        <x-brand></x-brand>
    </div>
</nav>
