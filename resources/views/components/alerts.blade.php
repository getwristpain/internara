@props([
    'messages' => [],
    'styles' => [
        'alert' => [
            'info' => [
                'class' => 'alert alert-info',
                'icon' => 'mdi:information-outline',
            ],
            'success' => [
                'class' => 'alert alert-success',
                'icon' => 'mdi:check-circle-outline',
            ],
            'warning' => [
                'class' => 'alert alert-warning',
                'icon' => 'mdi:alert-outline',
            ],
            'error' => [
                'class' => 'alert alert-error',
                'icon' => 'mdi:close-circle-outline',
            ],
            'default' => [
                'class' => 'alert',
                'icon' => 'mdi:message-alert-outline',
            ],
        ],
        'cta' => [
            'info' => 'btn btn-info btn-sm',
            'succes' => 'btn btn-success btn-sm',
            'warning' => 'btn btn-warning btn-sm',
            'error' => 'btn btn-error btn-sm',
            'default' => 'btn btn-sm',
        ],
    ],
    'component' => [
        'class' => 'font-medium',
    ],
])

@if (!empty($messages))
    <div {{ $attributes->merge(['class' => 'w-full space-y-4']) }}>
        @foreach ($messages as $message)
            @php
                if (is_string($message)) {
                    $text = $message;
                    $status = 'default';
                    $action = null;
                    $actionText = null;
                } else {
                    $text = $message['text'] ?? '';
                    $status = $message['status'] ?? 'default';
                    $action = $message['action'] ?? null;
                    $actionText = $message['actionText'] ?? null;
                }

                $alertStyle = $styles['alert'][$status] ?? $styles['alert']['default'];
                $ctaStyle = $styles['cta'][$status] ?? $styles['cta']['default'];
            @endphp

            <div class="flex {{ $component['class'] }} {{ $alertStyle['class'] }}">
                <iconify-icon class="scale-110" icon="{{ $alertStyle['icon'] }}"></iconify-icon>
                <span>{{ $text }}</span>
                @if (isset($action) && isset($actionText))
                    <button class="ml-auto {{ $ctaStyle }}"
                        wire:click.prevent="{{ $action }}">{{ $actionText }}</button>
                @endif
            </div>
        @endforeach
    </div>
@endif
