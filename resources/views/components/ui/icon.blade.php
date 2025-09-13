@props([
    'attributes' => [],
    'class' => 'icon-md',
    'icon' => '',
])

@php
    $isIconify = count(explode(':', $icon)) >= 2;
@endphp

@if ($isIconify)
    <iconify-icon class="{{ $class }}" icon="{{ $icon }}" {{ $attributes }}></iconify-icon>
@else
    <x-icon class="{{ $class }}" name="{{ $icon }}" {{ $attributes }}></x-icon>
@endif
