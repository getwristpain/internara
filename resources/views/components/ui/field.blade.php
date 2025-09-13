@props([
    'type' => 'text',
    'field' => '',
    'label' => null,
    'hint' => null,
    'required' => false,
    'markRequired' => false,
    'disabled' => false,
    'hidden' => false,
    'class' => '',
    'style' => [],
])

@php
    // Normalisasi name
    $name = str($field)->replace('.', '_')->snake()->toString();

    // Component name
    $componentName = in_array($type, ['input', 'select', 'checkbox', 'image']) ? $type : 'input';

    // Required marker
    $markRequired = $required ?: $markRequired;

    // Error state
    $hasErrors = $errors->has($field);

    $style = [
        'base' => css('w-full h-fit py-2 space-y-2', ['hidden' => $hidden]),
    ];

    $class = css($class, $style['base']);
@endphp

<div class="{{ $class }}">
    {{-- Label --}}
    @if ($label && $type !== 'checkbox')
        <x-ui.label for="{{ $name }}" :required="$markRequired" :$hint>
            {{ $label }}
        </x-ui.label>
    @endif

    {{-- Input --}}
    <div class="container" wire:key="{{ $name }}">
        @includeif("components.ui.form.{$componentName}", [
            'name' => $name,
            'class' => $style['input'] ?? '',
        ])
    </div>

    {{-- Error Messages --}}
    @if ($hasErrors)
        @include('components.ui.form.errors')
    @endif
</div>
