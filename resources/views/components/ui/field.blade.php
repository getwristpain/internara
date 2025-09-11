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

    // Bypass type
    $type = $type === 'error' ? 'text' : $type;

    // Required marker
    $markRequired = $required ?: $markRequired;

    // Error state
    $hasErrors = $errors->has($field);

    // Cek apakah file komponen input tersedia
    $componentExists = File::exists(resource_path("views/components/ui/form/{$type}.blade.php"));

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
    <div class="container">
        @if ($componentExists)
            @includeif("components.ui.form.{$type}", [
                'name' => $name,
                'class' => $style['input'] ?? '',
            ])
        @else
            @include('components.ui.form.input', [
                'name' => $name,
                'class' => $style['input'] ?? '',
            ])
        @endif
    </div>

    {{-- Error Messages --}}
    @if ($hasErrors)
        @include('components.ui.form.error')
    @endif
</div>
