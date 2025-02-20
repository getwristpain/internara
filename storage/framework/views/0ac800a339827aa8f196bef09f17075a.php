<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'hint' => null,
    'label' => null,
    'name' => '',
    'required' => false,
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
    'hint' => null,
    'label' => null,
    'name' => '',
    'required' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if(isset($label)): ?>
    <div class="flex gap-1">
        <label class="<?php echo e(!$required ?: 'required'); ?>" for="<?php echo e($name); ?>"><?php echo e($label); ?></label>
        <?php if(isset($hint)): ?>
            <span class="text-sm text-gray-500">(<?php echo e($hint); ?>)</span>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-label.blade.php ENDPATH**/ ?>