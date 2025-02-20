<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => '',
    'label' => '',
    'help' => '',
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
    'name' => '',
    'label' => '',
    'help' => '',
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

<div <?php echo e($attributes->merge(['class' => 'flex flex-col gap-2 ' . (!$disabled ?: 'disabled')])); ?>">
    <?php if($label): ?>
        <label class="flex text-sm font-medium text-gray-600 <?php echo e(!$required ?: 'required'); ?>" for="<?php echo e($name); ?>">
            <span><?php echo e($label); ?></span>
            <?php if($help): ?>
                <span class="pl-1 text-gray-500">(<?php echo e($help); ?>)</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <div class="w-full p-4 space-y-4 border border-gray-300 rounded-lg min-h-12" id="<?php echo e($name); ?>">
        <?php echo e($slot); ?>

    </div>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-group.blade.php ENDPATH**/ ?>