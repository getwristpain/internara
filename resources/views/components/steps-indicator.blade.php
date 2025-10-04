@props([
    'current' => 2,
    'steps' => 4,
])

@php
    $current = (int) $current;
    $steps = (int) $steps;

    $indicator = [];
    for ($i = 1; $i <= $steps; $i++) {
        $indicator[$i] = $i === $current;
    }
@endphp

<div class="flex items-center gap-1">
    @foreach ($indicator as $item => $isCurrent)
        <span
            class="{{ css('block h-2 border rounded-full border-neutral-800 dark:border-neutral-200', ['w-6 bg-emerald-500' => $isCurrent, 'w-2' => !$isCurrent]) }}"></span>
    @endforeach
</div>
