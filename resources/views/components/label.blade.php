@props([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'hint' => null,
    'label' => null,
    'name' => '',
    'required' => false,
])

@if (isset($label))
    <label class="{{ !$required ?: 'required' }}" for="{{ $name }}">
        <span>{{ $label }}</span>

        @if (isset($hint))
            <span class="text-sm text-gray-500">({{ $hint }})</span>
        @endif
    </label>
@endif
