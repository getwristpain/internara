<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action' => '',
    'disabled' => false,
    'icon' => null,
    'iconEffect' => '',
    'reverse' => false,
    'hideLabel' => false,
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
    'disabled' => false,
    'icon' => null,
    'iconEffect' => '',
    'reverse' => false,
    'hideLabel' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<button x-data="{
    rotated: false,
    iconEffect: <?php echo \Illuminate\Support\Js::from($iconEffect)->toHtml() ?>,
}" wire:click="<?php echo e($action); ?>"
    @click="
        if (iconEffect === 'rotate') {
            rotated = !rotated;
        }
    "
    <?php echo e($attributes->merge([
        'class' => implode(' ', ['btn', !$reverse ?: 'flex-row-reverse']),
        'disabled' => $disabled,
    ])); ?>

    type="button">

    <!--[if BLOCK]><![endif]--><?php if(isset($icon)): ?>
        <iconify-icon class="transition-transform duration-300" :class="{ 'rotate-180': rotated }"
            icon="<?php echo e($icon); ?>"></iconify-icon>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(!$hideLabel): ?>
        <span><?php echo e($slot); ?></span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</button>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/button.blade.php ENDPATH**/ ?>