@props([
    'hint' => null,
    'label' => null,
    'name' => '',
    'required' => false,
])

@if (isset($label))
    <div class="flex gap-1">
        <label class="{{ !$required ?: 'required' }}" for="{{ $name }}">{{ $label }}</label>
        @if (isset($hint))
            <span class="text-sm text-gray-500">({{ $hint }})</span>
        @endif
    </div>
@endif
