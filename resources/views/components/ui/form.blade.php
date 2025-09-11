@props([
    'name' => null,
    'submit' => '',
    'title' => null,
    'desc' => null,
    'bordered' => false,
    'shadowed' => false,
    'class' => 'w-full p-4 lg:p-8',
])

@php
    $name = str($name ?? 'form')
        ->camel()
        ->toString();
@endphp

<x-card class="{{ $class }}" :$title :$desc :$bordered :$shadowed>
    <form class="wh-full flex flex-col gap-4" id="{{ $name }}" wire:submit="{{ $submit }}">
        {{ $content ?? $slot }}
    </form>
</x-card>
