@props([
    'aspect' => null,
    'autofocus' => false,
    'class' => null,
    'disabled' => false,
    'field' => '',
    'hint' => null,
    'icon' => 'lucide:form-input',
    'label' => null,
    'placeholder' => '',
    'required' => false,
    'type' => 'text',
])

<div class="w-full">
    @if ($type === 'image')
        @include('partials.input.input-image')
    @else
        @include('partials.input.input-text')
    @endif
</div>
