<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'autofocus' => false,
    'component' => [],
    'disabled' => false,
    'height' => '',
    'help' => '',
    'hideMessages' => false,
    'icon' => 'tabler:edit',
    'id' => '',
    'label' => '',
    'max' => null,
    'messages' => [],
    'min' => null,
    'model' => '',
    'pattern' => null,
    'placeholder' => '',
    'required' => false,
    'step' => null,
    'type' => 'text',
    'unit' => '',
    'width' => 'w-full',
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
    'autofocus' => false,
    'component' => [],
    'disabled' => false,
    'height' => '',
    'help' => '',
    'hideMessages' => false,
    'icon' => 'tabler:edit',
    'id' => '',
    'label' => '',
    'max' => null,
    'messages' => [],
    'min' => null,
    'model' => '',
    'pattern' => null,
    'placeholder' => '',
    'required' => false,
    'step' => null,
    'type' => 'text',
    'unit' => '',
    'width' => 'w-full',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div>
    <!--[if BLOCK]><![endif]--><?php if($type === 'image'): ?>
        <?php if (isset($component)) { $__componentOriginal399f34ce636ececf97a274893bd59a15 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal399f34ce636ececf97a274893bd59a15 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-image','data' => ['component' => $component,'disabled' => $disabled,'id' => $id,'model' => $model,'label' => $label]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['component' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($component),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($disabled),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal399f34ce636ececf97a274893bd59a15)): ?>
<?php $attributes = $__attributesOriginal399f34ce636ececf97a274893bd59a15; ?>
<?php unset($__attributesOriginal399f34ce636ececf97a274893bd59a15); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal399f34ce636ececf97a274893bd59a15)): ?>
<?php $component = $__componentOriginal399f34ce636ececf97a274893bd59a15; ?>
<?php unset($__componentOriginal399f34ce636ececf97a274893bd59a15); ?>
<?php endif; ?>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['autofocus' => $autofocus,'component' => $component,'disabled' => $disabled,'hight' => $hight,'help' => $help,'icon' => $icon,'id' => $id,':max' => true,'min' => $min,'model' => $model,'pattern' => $pattern,'placeholder' => $placeholder,'required' => $required,'step' => $step,'type' => $type,'unit' => $unit,'width' => $width]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['autofocus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($autofocus),'component' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($component),'disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($disabled),'hight' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hight),'help' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($help),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($id),':max' => true,'min' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($min),'model' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($model),'pattern' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pattern),'placeholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($placeholder),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'step' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($step),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type),'unit' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unit),'width' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($width)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input.blade.php ENDPATH**/ ?>