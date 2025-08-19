@props([
    'delay' => '0ms',
    'duration' => '700ms',
    'enter' => 'transition ease-out',
    'enterStart' => 'opacity-0 translate-y-10',
    'enterEnd' => 'opacity-100 translate-y-0',
])

<div x-data="{ show: false }" x-intersect:enter.once="show = true" {{ $attributes }}>
    <div x-show="show" x-transition:enter="{{ $enter }}" x-transition:enter-start="{{ $enterStart }}"
        x-transition:enter-end="{{ $enterEnd }}"
        x-bind:style="'transition-delay: {{ $delay }}; transition-duration: {{ $duration }};'">
        {{ $slot }}
    </div>
</div>
