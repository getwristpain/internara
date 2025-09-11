@props([
    'delay' => '0ms',
    'duration' => '700ms',
    'leave' => 'transition duration-700 ease-out',
    'leaveStart' => 'opacity-0 translate-y-10',
    'leaveEnd' => 'opacity-100 translate-y-0',
])

<div x-data="{ show: false }" x-intersect:leave.once="show = true" {{ $attributes }}>
    <div x-show="show" x-transition:leave="{{ $leave }}" x-transition:leave-start="{{ $leaveStart }}"
        x-transition:leave-end="{{ $leaveEnd }}"
        x-bind:style="'transition-delay: {{ $delay }}; transition-duration: {{ $duration }};'">
        {{ $slot }}
    </div>
</div>
