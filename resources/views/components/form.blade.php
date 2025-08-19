@props([
    'bordered' => false,
    'class' => 'w-full',
    'desc' => null,
    'shadowed' => false,
    'submit' => '',
    'title' => null,
    'name' => null,
])

@php
    $name = str($name ?? 'form')
        ->camel()
        ->toString();
@endphp

<x-card class="{{ $class }}" :$title :$desc :$bordered :$shadowed>
    <form class="wh-full flex flex-col gap-12" id="{{ $name }}" wire:submit="{{ $submit }}">
        {{ $content ?? $slot }}
    </form>
</x-card>
