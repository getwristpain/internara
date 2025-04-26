<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'currentStep' => '',
    'steps' => '',
    'title' => '',
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
    'currentStep' => '',
    'steps' => '',
    'title' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="flex flex-col w-full gap-4 min-h-20">
    <div class="flex items-center justify-between text-xs text-gray-400">
        <span class="text-subheading"><?php echo e($title); ?></span>
        <span><span class="font-bold"><?php echo e($currentStep); ?></span>/<?php echo e($steps); ?></span>
    </div>
    <div class="flex w-full">
        <div class="relative flex items-center w-full h-2 rounded-full bg-primary bg-opacity-10">
            <div class="absolute flex items-center justify-between w-full">
                <?php for($i = 1; $i < $steps; $i++): ?>
                    <div
                        class="flex items-center justify-center w-full h-2 <?php echo e($currentStep > $i ? 'bg-primary bg-opacity-70' : 'bg-primary-100'); ?>">
                        <span class="before:content-['']"></span>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="absolute flex items-center justify-between w-full gap-4">
                <?php for($i = 0; $i < $steps; $i++): ?>
                    <div
                        class="flex items-center justify-center w-6 h-6 rounded-full font-bold text-xs text-base-100 <?php echo e($currentStep > $i ? 'bg-primary' : 'bg-primary-100'); ?>">
                        <?php if($currentStep > $i): ?>
                            <iconify-icon icon="mingcute:check-fill"></iconify-icon>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/stepbar.blade.php ENDPATH**/ ?>