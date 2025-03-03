@props([
    'title' => null,
    'favicon' => null,
])

<x-layouts.app :$title :$favicon>
    <div class="flex flex-col wh-full">
        <x-navbar></x-navbar>

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</x-layouts.app>
