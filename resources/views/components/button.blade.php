@props([
    'action' => '',
    'disabled' => false,
    'icon' => null,
    'iconEffect' => '',
    'reverse' => false,
])

<button x-data="{
    rotated: false,
    action: @js($action),
    iconEffect: @js($iconEffect),
}"
    @click="
        if (iconEffect === 'rotate') {
            rotated = !rotated;
        }

        if (action.startsWith('$dispatch')) {
            let match = action.match(/\$dispatch\('([^']+)'\)/);
            if (match) {
                $dispatch(match[1]);
            }
        } else if (action) {
            $wire.call(action);
        }
    "
    {{ $attributes->merge([
        'class' => implode(' ', ['btn', !$reverse ?: 'flex-row-reverse']),
        'disabled' => $disabled,
    ]) }}>

    @if ($icon)
        <iconify-icon class="transition-transform duration-300" :class="{ 'rotate-180': rotated }"
            icon="{{ $icon }}"></iconify-icon>
    @endif

    <span>{{ $slot }}</span>
</button>
