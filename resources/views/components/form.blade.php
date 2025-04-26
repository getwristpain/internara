@props(['disabled' => false, 'name', 'submit', 'messages' => session('messages', [])])

<form
    {{ $attributes->merge(['id' => $name, 'name' => $name, 'class' => implode(' ', ['flex flex-col gap-8', $disabled ? 'disabled' : '']), 'disabled' => $disabled]) }}
    wire:submit.prevent="{{ $submit }}">
    @if (isset($header))
        <div>
            {{ $header }}
        </div>
    @endif

    @if (!empty($messages))
        <div class="flex flex-col gap-4">
            <x-flash-messages :$messages></x-flash-messages>
        </div>
    @endif

    <div class="flex flex-col gap-4">
        {{ $body ?? $slot }}
    </div>

    @if (isset($footer))
        <div class="flex justify-end w-full gap-4">
            {{ $footer }}
        </div>
    @endif
</form>
