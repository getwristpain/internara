<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action' => '',
    'component' => [
        'buttonStyles' => 'btn',
    ],
    'disabled' => false,
    'icon' => null,
    'reverse' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'action' => '',
    'component' => [
        'buttonStyles' => 'btn',
    ],
    'disabled' => false,
    'icon' => null,
    'reverse' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<button wire:click.prevent="<?php echo e($action); ?>"
    <?php echo e($attributes->merge([
        'class' => implode(' ', [$component['buttonStyles'], !$reverse ?: 'flex-row-reverse']),
        'disabled' => $disabled,
    ])); ?>>

    <?php if(isset($icon)): ?>
        <iconify-icon icon="<?php echo e($icon); ?>"></iconify-icon>
    <?php endif; ?>

    <span><?php echo e($slot); ?></span>
</button>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/button.blade.php ENDPATH**/ ?>