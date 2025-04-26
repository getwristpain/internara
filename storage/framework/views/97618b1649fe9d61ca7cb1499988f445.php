<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
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
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes->merge([
    'class' => 'navbar bg-inherit bg-opacity-90 backdrop-blur-lg px-8 z-10',
])); ?>>
    <?php if (isset($component)) { $__componentOriginal6328f0deb07a8bef5ad2cd5691beb925 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6328f0deb07a8bef5ad2cd5691beb925 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.brand','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('brand'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6328f0deb07a8bef5ad2cd5691beb925)): ?>
<?php $attributes = $__attributesOriginal6328f0deb07a8bef5ad2cd5691beb925; ?>
<?php unset($__attributesOriginal6328f0deb07a8bef5ad2cd5691beb925); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6328f0deb07a8bef5ad2cd5691beb925)): ?>
<?php $component = $__componentOriginal6328f0deb07a8bef5ad2cd5691beb925; ?>
<?php unset($__componentOriginal6328f0deb07a8bef5ad2cd5691beb925); ?>
<?php endif; ?>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/navbar.blade.php ENDPATH**/ ?>