@props([
    'name' => '',
    'label' => '',
    'help' => '',
    'required' => false,
    'disabled' => false,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2 ' . (!$disabled ?: 'disabled')]) }}">
    @if ($label)
        <label class="flex text-sm font-medium text-gray-600 {{ !$required ?: 'required' }}" for="{{ $name }}">
            <span>{{ $label }}</span>
            @if ($help)
                <span class="pl-1 text-gray-500">({{ $help }})</span>
            @endif
        </label>
    @endif

    <div class="w-full p-4 space-y-4 border border-gray-300 rounded-lg min-h-12" id="{{ $name }}">
        {{ $slot }}
    </div>
</div>
