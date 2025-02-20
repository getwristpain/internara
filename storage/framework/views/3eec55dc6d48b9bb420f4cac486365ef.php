<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'errorMessages' => [],
    'hideErrors' => false,
    'model' => '',
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
    'errorMessages' => [],
    'hideErrors' => false,
    'model' => '',
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

<?php
    // Fixme: Cannot Display Image Preview
    $messages = $errorMessages ?: ($errors->has($model) ? $errors->get($model) : []);
?>

<div class="flex flex-col items-center justify-center w-full gap-2 border border-gray-300 rounded-lg">
    <div>
        <!--[if BLOCK]><![endif]--><?php if(!$model): ?>
            <?php if (isset($component)) { $__componentOriginald8df7172a1dcf52e21a74bcdceb15e43 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-media','data' => ['class' => 'h-24']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-24']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43)): ?>
<?php $attributes = $__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43; ?>
<?php unset($__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8df7172a1dcf52e21a74bcdceb15e43)): ?>
<?php $component = $__componentOriginald8df7172a1dcf52e21a74bcdceb15e43; ?>
<?php unset($__componentOriginald8df7172a1dcf52e21a74bcdceb15e43); ?>
<?php endif; ?>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php if(method_exists($model, 'temporaryUrl')): ?>
                <img src="<?php echo e($model->temporaryUrl()); ?>" alt="">
            <?php else: ?>
                <img src="<?php echo e($model ?? ''); ?>" alt="">
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <!--[if BLOCK]><![endif]--><?php if(!empty($errorMessages) && !$hideErrors): ?>
        <div>
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $messages]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($messages)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-media.blade.php ENDPATH**/ ?>