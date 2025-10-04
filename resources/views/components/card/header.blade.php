@props([
    'title' => null,
    'description' => null,
])

<div class="flex flex-col text-center">
    <div class="flex justify-between gap-4">
        {{ $slot }}
    </div>

    <flux:heading size="lg">
        {{ $title }}
    </flux:heading>

    <flux:subheading size="lg">
        {{ $description }}
    </flux:subheading>
</div>
