@props([
    'class' => '',
    'fixed' => false,
    'style' => [],
    'home_url' => '/',
])

@php
    $style['navbar'] = 'navbar glass shadow-none px-4 md:px-8 lg:px-16';
    $style['fixed'] = $fixed ? 'fixed z-10 top-0 left-0' : 'block';

    $class .= ' ' . implode(' ', array_values($style));
@endphp

<nav class="{{ $class }}">
    <div class="container mx-auto w-full">
        <x-brand url="{{ $home_url }}" />
    </div>
</nav>
