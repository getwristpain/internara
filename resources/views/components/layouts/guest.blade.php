@props([
    'title' => null,
    'favicon' => null,
])

<x-layouts.app :$title :$favicon>
    <x-bg-decoration></x-bg-decoration>
    <x-navbar fixed shadowed></x-navbar>
    <main class="wh-screen">{{ $slot }}</main>
</x-layouts.app>
