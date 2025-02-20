<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'url' => asset('images/logo.png'),
    'alt' => 'Logo',
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
    'url' => asset('images/logo.png'),
    'alt' => 'Logo',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'avatar w-4 scale-125'])); ?>>
    <img class="aspect-square object-cover object-center" src="<?php echo e($url); ?>" alt="<?php echo e($alt); ?>">
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/logo.blade.php ENDPATH**/ ?>