@props([
    'height' => 8,
    'fixed' => false,
    'shadowed' => false,
])

@php
    $navbarClass = "flex items-center justify-between gap-4 p-4 glass w-full min-h-4 max-h-{$height}";
    $navbarClass .= $fixed ? ' fixed z-10 top-0 left-0' : 'block';
    $navbarClass .= $shadowed ? ' shadow-xl shadow-neutral-300' : '';
@endphp

<nav {{ $attributes->merge(['class' => $navbarClass]) }}>
    <div class="flex gap-4 items-center">
        <x-brand :$height></x-brand>
    </div>
</nav>
