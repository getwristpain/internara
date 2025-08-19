@props([
    'delay' => '0ms',
    'duration' => '700ms',
    'enter' => 'transition ease-out',
    'enterEnd' => 'opacity-100 translate-y-0',
    'enterStart' => 'opacity-0 translate-y-10',
    'leave' => 'transition ease-in',
    'leaveEnd' => 'opacity-0 translate-y-10',
    'leaveStart' => 'opacity-100 translate-y-0',
])

<div x-data="{ show: false }" x-intersect:enter.once="show = true" x-intersect:leave.once="show = false"
    {{ $attributes }}>
    <div x-show="show" x-transition:enter="{{ $enter }}" x-transition:enter-start="{{ $enterStart }}"
        x-transition:enter-end="{{ $enterEnd }}" x-transition:leave="{{ $leave }}"
        x-transition:leave-start="{{ $leaveStart }}" x-transition:leave-end="{{ $leaveEnd }}"
        x-bind:style="'transition-delay: {{ $delay }}; transition-duration: {{ $duration }};'">
        {{ $slot }}
    </div>
</div>
