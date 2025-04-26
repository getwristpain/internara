<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'model' => '',
    'name' => '',
    'label' => '',
    'required' => false,
    'disabled' => false,
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
    'model' => '',
    'name' => '',
    'label' => '',
    'required' => false,
    'disabled' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div>
    <label class="flex items-center cursor-pointer <?php echo e($required ? 'required' : ''); ?> <?php echo e($disabled ? 'disabled' : ''); ?>"
        for="<?php echo e($name); ?>">
        <input class="checkbox checkbox-sm checkbox-neutral rounded-full" id="<?php echo e($name); ?>"
            name="<?php echo e($name); ?>" wire:model.live="<?php echo e($model); ?>" type="checkbox"
            <?php echo e($required ? 'required' : ''); ?> <?php echo e($disabled ? 'disabled' : ''); ?> />
        <span class="pl-2"><?php echo e($label); ?></span>
    </label>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-checkbox.blade.php ENDPATH**/ ?>