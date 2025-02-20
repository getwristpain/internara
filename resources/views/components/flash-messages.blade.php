@props([
    'messages' => session('messages', []),
    'component' => [
        'class' => 'alert-sm',
    ],
])

@if (!empty($messages))
    <x-alerts :$messages :$component></x-alerts>
@endif
