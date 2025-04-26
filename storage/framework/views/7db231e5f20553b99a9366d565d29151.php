<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
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
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
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

<!--[if BLOCK]><![endif]--><?php if(isset($label)): ?>
    <label class="<?php echo e(!$required ?: 'required'); ?>" for="<?php echo e($name); ?>">
        <span><?php echo e($label); ?></span>

        <!--[if BLOCK]><![endif]--><?php if(isset($hint)): ?>
            <span class="text-sm text-gray-500">(<?php echo e($hint); ?>)</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </label>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/label.blade.php ENDPATH**/ ?>