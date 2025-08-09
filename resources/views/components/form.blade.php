@props([
    'action' => '',
    'bordered' => false,
    'shadowed' => false,
    'title' => null,
    'desc' => null,
])

<x-card class="w-full max-w-2xl" :$title :$desc :$bordered :$shadowed>
    <form class="flex flex-col gap-12" wire:submit="{{ $action }}" {{ $attributes }}>
        {{ $content ?? $slot }}
    </form>
</x-card>
