@props([
    'label' => '',
    'previous' => '',
    'previousUrl' => '#',
    'current' => 0,
    'steps' => 6,
])

<div class="flex w-full items-center justify-between gap-4 text-sm font-medium">
    {{-- Previous --}}
    <div>
        <a class="flex flex-nowrap items-center gap-2 text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100"
            href="{{ $previousUrl }}" wire:navigate>
            <flux:icon class="size-4" name="arrow-long-left" />
            <span>{{ $previous }}</span>
        </a>
    </div>

    {{-- Current --}}
    <div class="flex items-center gap-4 font-bold text-neutral-600 dark:text-neutral-400">
        <x-steps-indicator :$current :$steps />
        <span class="hidden lg:block">{{ $label }}</span>
        <span>{{ $current }}/{{ $steps }}</span>
    </div>
</div>
