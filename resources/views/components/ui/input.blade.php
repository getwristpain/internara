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
    // Normalisasi ID
    $id = str($field)->replace('.', '_')->snake()->toString();

    // Required marker
    $markRequired = $required ?: $markRequired;

    // Error state
    $hasErrors = $errors->has($field);

    // Cek apakah file komponen input tersedia
    $componentExists = File::exists(resource_path("views/components/input/{$type}.blade.php"));

    // Style wrapper
    $style['component'] = [
        'container' => 'w-full h-fit py-2 space-y-2',
        'hidden' => $hidden ? 'hidden' : '',
    ];

    // Style input (array, default kosong → bisa diisi child)
    $style['input'] = [
        'base' => '',
    ];

    // Format ke string
    $inputClass = trim(implode(' ', array_values($style['input'])));
    $class = trim($class . ' ' . implode(' ', array_values($style['component'])));
@endphp

@if ($type === 'checkbox')
    @include('components.input.checkbox', [
        'class' => $class,
    ])
@else
    <div class="{{ $class }}">
        @isset($label)
            <x-label for="{{ $id }}" :required="$markRequired" :$hint>
                {{ $label }}
            </x-label>
        @endisset

        <div class="container">
            @if ($type !== 'error' && $componentExists)
                @includeif("components.input.{$type}", [
                    'class' => $inputClass,
                ])
            @else
                @include('components.input.text', [
                    'class' => $inputClass,
                ])
            @endif
        </div>

        @if ($hasErrors)
            @include('components.input.error')
        @endif
    </div>
@endif
