@props([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'form' => null,
    'icon' => 'icon-park-outline:right-c',
    'hideIcon' => false,
    'reverse' => false,
])

<button
    {{ $attributes->merge([
        'type' => 'submit',
        'form' => $form,
        'class' => 'btn btn-primary ' . ($reverse ? 'flex-row-reverse' : ''),
    ]) }}
    wire:loading.class="disabled" wire:loading.attr="disabled">
    <span>{{ $slot }}</span>
    @if ($icon && !$hideIcon)
        <iconify-icon icon="{{ $icon }}"></iconify-icon>
    @endif
</button>
