<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => [],
    'autofocus' => false,
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'icon' => 'tabler:edit',
    'inputClass' => '',
    'label' => null,
    'max' => null,
    'messages' => [],
    'min' => null,
    'model' => '',
    'name' => '',
    'pattern' => null,
    'placeholder' => '',
    'required' => false,
    'step' => null,
    'type' => 'text',
    'unit' => '',
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
    'attributes' => [],
    'autofocus' => false,
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'icon' => 'tabler:edit',
    'inputClass' => '',
    'label' => null,
    'max' => null,
    'messages' => [],
    'min' => null,
    'model' => '',
    'name' => '',
    'pattern' => null,
    'placeholder' => '',
    'required' => false,
    'step' => null,
    'type' => 'text',
    'unit' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $iconStyle =
        'absolute text-lg text-gray-400 left-3 z-[2] ' .
        ($type === 'textarea' ? 'top-4' : 'top-1/2 transform -translate-y-1/2');

    $messages = !empty($messages) ? $message : ($errors->has($model) ? $errors->get($model) : []);

    $inputStyle = implode(' ', [
        'input input-bordered w-full py-3 pl-10 pr-3 focus:outline-none focus:ring-2 disabled:disabled',
        !empty($messages) ? 'border-error focus:ring-error' : 'focus:ring-neutral',
        $inputClass,
    ]);
?>

<div <?php echo e($attributes->merge(['class' => implode(' ', ['flex flex-col w-full gap-2', $disabled ? 'disabled' : ''])])); ?>>
    <?php if (isset($component)) { $__componentOriginald8ba2b4c22a13c55321e34443c386276 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8ba2b4c22a13c55321e34443c386276 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.label','data' => ['name' => $name,'label' => $label,'required' => $required,'hint' => $hint]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($name),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hint)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $attributes = $__attributesOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__attributesOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8ba2b4c22a13c55321e34443c386276)): ?>
<?php $component = $__componentOriginald8ba2b4c22a13c55321e34443c386276; ?>
<?php unset($__componentOriginald8ba2b4c22a13c55321e34443c386276); ?>
<?php endif; ?>

    <div class="flex items-center gap-2">
        <div class="relative w-full">
            <iconify-icon class="<?php echo e($iconStyle); ?>"
                icon="<?php echo e(match ($type) {
                    'address' => 'mdi:address-marker',
                    'email' => 'mdi:email',
                    'idcard' => 'mingcute:idcard-fill',
                    'mobile' => 'basil:mobile-phone-outline',
                    'name' => 'mdi:user',
                    'number' => 'tabler:number-123',
                    'password' => 'mdi:password',
                    'person' => 'mdi:user',
                    'phone' => 'mdi:phone',
                    'postcode' => 'material-symbols:local-post-office-rounded',
                    'search' => 'ion:search-sharp',
                    'time' => 'lineicons:alarm-clock',
                    default => $icon,
                }); ?>"></iconify-icon>

            <?php if($type === 'textarea'): ?>
                <textarea class="<?php echo e($inputStyle . ' min-h-40'); ?>" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                    <?php if($model): ?> wire:model.live.debounce.1000ms="<?php echo e($model); ?>" <?php endif; ?>
                    <?php echo e($attributes->merge([
                        'autocomplete' => $name,
                        'autofocus' => $autofocus,
                        'disabled' => $disabled,
                        'max' => $max,
                        'min' => $min,
                        'pattern' => $pattern,
                        'placeholder' => $placeholder,
                        'required' => $required,
                        'step' => $step,
                        'style' => 'font-weight: inherit',
                        'title' => $placeholder,
                    ])); ?>

                    aria-describedby="<?php echo e($name); ?>-error"></textarea>
            <?php elseif($type === 'date'): ?>
                <input class="<?php echo e($inputStyle); ?>" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                    type="<?php echo e($type); ?>"
                    <?php if($model): ?> wire:model.live="<?php echo e($model); ?>" <?php endif; ?>
                    <?php echo e($attributes->merge([
                        'autocomplete' => $name,
                        'autofocus' => $autofocus,
                        'disabled' => $disabled,
                        'max' => $max,
                        'min' => $min,
                        'pattern' => $pattern,
                        'placeholder' => $placeholder,
                        'required' => $required,
                        'step' => $step,
                        'style' => 'font-weight: inherit',
                        'title' => $placeholder,
                    ])); ?>

                    aria-describedby="<?php echo e($name); ?>-error">
            <?php else: ?>
                <input class="<?php echo e($inputStyle); ?>" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                    type="<?php echo e($type); ?>"
                    <?php if($model): ?> wire:model.live.debounce.1000ms="<?php echo e($model); ?>" <?php endif; ?>
                    <?php echo e($attributes->merge([
                        'autocomplete' => $name,
                        'autofocus' => $autofocus,
                        'disabled' => $disabled,
                        'max' => $max,
                        'min' => $min,
                        'pattern' => $pattern,
                        'placeholder' => $placeholder,
                        'required' => $required,
                        'step' => $step,
                        'style' => 'font-weight: inherit',
                        'title' => $placeholder,
                    ])); ?>

                    aria-describedby="<?php echo e($name); ?>-error">
            <?php endif; ?>
        </div>

        <?php if($unit): ?>
            <span class="text-sm font-medium text-gray-500"><?php echo e($unit); ?></span>
        <?php endif; ?>
    </div>

    <?php if($messages && !$hideMessages): ?>
        <div>
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2','messages' => $messages]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($messages)]); ?>
<?php echo $__env->renderComponent(); ?>
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
    <?php endif; ?>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-text.blade.php ENDPATH**/ ?>