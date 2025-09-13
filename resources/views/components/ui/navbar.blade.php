@props([
    'attributes' => [],
    'home_url' => '/',
    'type' => 'glassy',
    'fixed' => false,
])

<nav x-data x-cloak :class="@js(
    css('navbar px-4 lg:px-8 w-full', [
        'fixed z-10 top-0 left-0' => $fixed,
        'glass shadow-none' => $type === 'glassy',
    ]),
)" {{ $attributes }}>
    {{-- Content --}}
    <div class="container mx-auto">
        {{-- Brand --}}
        <x-ui.brand url="{{ $home_url }}" />
        {{-- Menu --}}
        <div class="flex items-center justify-between gap-4">
            {{ $slot }}
        </div>
    </div>
</nav>
