<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
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
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
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

<button
    <?php echo e($attributes->merge([
        'type' => 'submit',
        'form' => $form,
        'class' => 'btn btn-primary ' . ($reverse ? 'flex-row-reverse' : ''),
    ])); ?>

    wire:loading.class="disabled" wire:loading.attr="disabled">
    <span><?php echo e($slot); ?></span>
    <?php if($icon && !$hideIcon): ?>
        <iconify-icon icon="<?php echo e($icon); ?>"></iconify-icon>
    <?php endif; ?>
</button>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/submit.blade.php ENDPATH**/ ?>