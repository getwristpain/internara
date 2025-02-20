@props(['name', 'submit', 'messages' => session('messages', [])])

<form id="{{ $name }}" name="{{ $name }}" wire:submit.prevent="{{ $submit }}">
    @if (isset($header))
        <div>
            {{ $header }}
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <x-flash-messages :$messages></x-flash-messages>
    </div>

    <div class="flex flex-col gap-4">
        {{ $body ?? $slot }}
    </div>

    @if (isset($footer))
        <div class="flex justify-end w-full gap-4">
            {{ $footer }}
        </div>
    @endif
</form>
