@props([
    'action' => '',
    'bordered' => false,
    'shadowed' => false,
    'title' => null,
])

<x-card class="w-full max-w-2xl" :$title :$bordered :$shadowed>
    <form class="flex flex-col gap-12" wire:submit="{{ $action }}" {{ $attributes }}>
        {{ $content ?? $slot }}
    </form>
</x-card>
