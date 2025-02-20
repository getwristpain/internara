<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'component' => [
        'buttonStyles' => 'btn btn-primary',
    ],
    'form' => null,
    'icon' => 'icon-park-outline:right-c',
    'hideIcon' => false,
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
    'component' => [
        'buttonStyles' => 'btn btn-primary',
    ],
    'form' => null,
    'icon' => 'icon-park-outline:right-c',
    'hideIcon' => false,
    'reverse' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<button type="submit"
    <?php echo e($attributes->merge([
        'class' => implode(' ', [$component['buttonStyles'], !$reverse ?: 'flex-row-reverse']),
        'form' => $form,
    ])); ?>>
    <span><?php echo e($slot); ?></span>

    <?php if(isset($icon) && !$hideIcon): ?>
        <iconify-icon icon="<?php echo e($icon); ?>"></iconify-icon>
    <?php endif; ?>
</button>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/button-submit.blade.php ENDPATH**/ ?>