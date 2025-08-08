@props([
    'delay' => 0,
    'enter' => 'transition duration-700 ease-out',
    'enterStart' => 'opacity-0 translate-y-10',
    'enterEnd' => 'opacity-100 translate-y-0',
])

<div x-data="{ show: false }" x-intersect:enter.once="show = true" {{ $attributes }}>
    <div x-show="show" x-transition:enter="{{ $enter }}" x-transition:enter-start="{{ $enterStart }}"
        x-transition:enter-end="{{ $enterEnd }}" x-bind:style="'transition-delay: {{ $delay }}ms'">
        {{ $slot }}
    </div>
</div>
