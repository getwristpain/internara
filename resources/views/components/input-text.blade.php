@props([
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
    $iconClass =
        'absolute text-lg text-gray-400 left-3 ' .
        ($type === 'textarea' ? 'top-4' : 'top-1/2 transform -translate-y-1/2');

    $messages = !empty($messages) ? $message : ($errors->has($model) ? $errors->get($model) : []);
@endphp

<div class="flex flex-col gap-2 w-full">
    <x-input-label :$name :$label :$required :$hint></x-input-label>

    <div class="flex items-center gap-2">
        <div class="relative w-full">
            <iconify-icon class="{{ $iconClass }}"
                icon="{{ match ($type) {
                    'email' => 'mdi:email',
                    'password' => 'mdi:password',
                    'number' => 'tabler:number-123',
                    'search' => 'ion:search-sharp',
                    'address' => 'mdi:address-marker',
                    'person' => 'mdi:user',
                    'idcard' => 'mingcute:idcard-fill',
                    'phone' => 'mdi:phone',
                    'mobile' => 'basil:mobile-phone-outline',
                    'postcode' => 'material-symbols:local-post-office-rounded',
                    'time' => 'lineicons:alarm-clock',
                    default => $icon,
                } }}"></iconify-icon>

            @if ($type === 'textarea')
                <textarea id="{{ $name }}" name="{{ $name }}"
                    @if ($model) wire:model.live.debounce.1000ms="{{ $model }}" @endif
                    placeholder="{{ $placeholder }}" autocomplete="{{ $name }}"
                    {{ $attributes->merge([
                        'class' =>
                            'w-full py-3 pl-10 pr-3 input input-bordered min-h-40 focus:outline-none focus:ring-2 focus:ring-neutral disabled' .
                            (empty($errorMessages) ? '' : ' border-error focus:ring-error'),
                        'disabled' => $disabled,
                        'autofocus' => $autofocus,
                        'required' => $required,
                        'maxlength' => $max,
                        'pattern' => $pattern,
                    ]) }}
                    aria-describedby="{{ $name }}-error"></textarea>
            @elseif ($type === 'date')
                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                    @if ($model) wire:model.live="{{ $model }}" @endif
                    placeholder="{{ $placeholder }}" autocomplete="{{ $name }}"
                    {{ $attributes->merge([
                        'class' =>
                            'w-full pl-10 input input-bordered focus:outline-none focus:ring-2 focus:ring-neutral
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            disabled' .
                            (empty($errorMessages) ? '' : ' border-error focus:ring-error'),
                        'disabled' => $disabled,
                        'autofocus' => $autofocus,
                        'required' => $required,
                        'max' => $max,
                        'min' => $min,
                        'step' => $step,
                        'pattern' => $pattern,
                    ]) }}
                    aria-describedby="{{ $name }}-error">
            @else
                <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                    @if ($model) wire:model.live.debounce.1000ms="{{ $model }}" @endif
                    placeholder="{{ $placeholder }}" autocomplete="{{ $name }}"
                    {{ $attributes->merge([
                        'class' =>
                            'w-full pl-10 input input-bordered focus:outline-none focus:ring-2 focus:ring-neutral
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            disabled' .
                            (empty($errorMessages) ? '' : ' border-error focus:ring-error'),
                        'disabled' => $disabled,
                        'autofocus' => $autofocus,
                        'required' => $required,
                        'max' => $max,
                        'min' => $min,
                        'step' => $step,
                        'pattern' => $pattern,
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
            <x-input-error class="mt-2" :$messages />
        </div>
    @endif
</div>
