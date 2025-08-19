@props([
    'aspect' => null,
    'autofocus' => false,
    'class' => null,
    'disabled' => false,
    'field' => '',
    'hint' => null,
    'icon' => null,
    'label' => null,
    'placeholder' => '',
    'preview' => null,
    'required' => false,
    'size' => null,
    'type' => null,
])

<div class="w-full">
    @if ($type === 'image')
        @include('partials.input.input-image')
    @elseif ($type === 'select')
        @include('components.select')
    @else
        @include('partials.input.input-text')
    @endif
</div>
