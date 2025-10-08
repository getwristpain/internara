@props([
    'title' => null,
    'description' => null,
    'size' => 'lg',
])

<div class="flex flex-col items-center pb-6">
    <div class="flex justify-between gap-4">
        {{ $slot }}
    </div>

    @isset($title)
        <flux:heading :$size>
            {{ $title }}
        </flux:heading>
    @endisset

    @isset($description)
        <flux:subheading :$size>
            {{ $description }}
        </flux:subheading>
    @endisset
</div>
