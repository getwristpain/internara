<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'url' => asset(app(\App\Services\SystemService::class)->first()->logo),
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
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'url' => asset(app(\App\Services\SystemService::class)->first()->logo),
    'alt' => 'Logo',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'w-full scale-125 avatar aspect-square'])); ?>>
    <!-- Logo Images -->
    <img class="object-cover object-center aspect-square" src="<?php echo e($url); ?>" alt="<?php echo e($alt); ?>"
        title="<?php echo e($url); ?>">
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/logo.blade.php ENDPATH**/ ?>