@props([
    'type' => 'text',
])

@if ($type === 'image')
    <x-input.image :$type {{ $attributes }} />
@elseif ($type === 'select')
    <x-input.select :$type {{ $attributes }} />
@elseif ($type === 'checkbox')
    <x-input.checkbox :$type {{ $attributes }} />
@else
    <x-input.text :$type {{ $attributes }} />
@endif
