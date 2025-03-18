@props([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'autofocus' => false,
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'icon' => 'tabler:edit',
    'label' => null,
    'max' => null,
    'messages' => [],
    'min' => null,
    'model' => '',
    'name' => '',
    'pattern' => null,
    'placeholder' => '',
    'required' => false,
    'step' => null,
    'type' => 'text',
    'unit' => '',
])

@php
    $iconStyle =
        'absolute text-lg text-gray-400 left-3 ' .
        ($type === 'textarea' ? 'top-4' : 'top-1/2 transform -translate-y-1/2');

    $messages = !empty($messages) ? $message : ($errors->has($model) ? $errors->get($model) : []);

    $inputStyle = implode(' ', [
        'input input-bordered w-full py-3 pl-10 pr-3 focus:outline-none focus:ring-2 disabled:disabled',
        !empty($messages) ? 'border-error focus:ring-error' : 'focus:ring-neutral',
    ]);
@endphp

<div class="flex flex-col w-full gap-2">
    <x-forms.input-label :$name :$label :$required :$hint></x-forms.input-label>

    <div class="flex items-center gap-2">
        <div class="relative w-full">
            <iconify-icon class="{{ $iconStyle }}"
                icon="{{ match ($type) {
                    'address' => 'mdi:address-marker',
                    'email' => 'mdi:email',
                    'idcard' => 'mingcute:idcard-fill',
                    'mobile' => 'basil:mobile-phone-outline',
                    'name' => 'mdi:user',
                    'number' => 'tabler:number-123',
                    'password' => 'mdi:password',
                    'person' => 'mdi:user',
                    'phone' => 'mdi:phone',
                    'postcode' => 'material-symbols:local-post-office-rounded',
                    'search' => 'ion:search-sharp',
                    'time' => 'lineicons:alarm-clock',
                    default => $icon,
                } }}"></iconify-icon>

            @if ($type === 'textarea')
                <textarea id="{{ $name }}" name="{{ $name }}"
                    @if ($model) wire:model.live.debounce.1000ms="{{ $model }}" @endif
                    {{ $attributes->merge([
                        'class' => $inputStyle . 'min-h-40',
                        'autocomplete' => $name,
                        'autofocus' => $autofocus,
                        'disabled' => $disabled,
                        'max' => $max,
                        'min' => $min,
                        'pattern' => $pattern,
                        'placeholder' => $placeholder,
                        'required' => $required,
                        'step' => $step,
                        'style' => 'font-weight: inherit',
                        'title' => $placeholder,
                    ]) }}
                    aria-describedby="{{ $name }}-error"></textarea>
            @elseif ($type === 'date')
                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                    @if ($model) wire:model.live="{{ $model }}" @endif
                    {{ $attributes->merge([
                        'class' => $inputStyle,
                        'autocomplete' => $name,
                        'autofocus' => $autofocus,
                        'disabled' => $disabled,
                        'max' => $max,
                        'min' => $min,
                        'pattern' => $pattern,
                        'placeholder' => $placeholder,
                        'required' => $required,
                        'step' => $step,
                        'style' => 'font-weight: inherit',
                        'title' => $placeholder,
                    ]) }}
                    aria-describedby="{{ $name }}-error">
            @else
                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                    @if ($model) wire:model.live.debounce.1000ms="{{ $model }}" @endif
                    {{ $attributes->merge([
                        'class' => $inputStyle,
                        'autocomplete' => $name,
                        'autofocus' => $autofocus,
                        'disabled' => $disabled,
                        'max' => $max,
                        'min' => $min,
                        'pattern' => $pattern,
                        'placeholder' => $placeholder,
                        'required' => $required,
                        'step' => $step,
                        'style' => 'font-weight: inherit',
                        'title' => $placeholder,
                    ]) }}
                    aria-describedby="{{ $name }}-error">
            @endif
        </div>

        @if ($unit)
            <span class="text-sm font-medium text-gray-500">{{ $unit }}</span>
        @endif
    </div>

    @if ($messages && !$hideMessages)
        <div>
            <x-forms.input-error class="mt-2" :$messages />
        </div>
    @endif
</div>
