<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'autofocus' => false,
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'icon' => 'tabler:edit',
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
    'attributes' => new \Illuminate\View\ComponentAttributeBag(),
    'autofocus' => false,
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'icon' => 'tabler:edit',
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
    $iconClass =
        'absolute text-lg text-gray-400 left-3 ' .
        ($type === 'textarea' ? 'top-4' : 'top-1/2 transform -translate-y-1/2');

    $messages = !empty($messages) ? $message : ($errors->has($model) ? $errors->get($model) : []);
?>

<div class="flex flex-col w-full gap-2">
    <?php if (isset($component)) { $__componentOriginalabddde62786fb871e8a66d2206a4e797 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalabddde62786fb871e8a66d2206a4e797 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-label','data' => ['name' => $name,'label' => $label,'required' => $required,'hint' => $hint]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($name),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($label),'required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($hint)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalabddde62786fb871e8a66d2206a4e797)): ?>
<?php $attributes = $__attributesOriginalabddde62786fb871e8a66d2206a4e797; ?>
<?php unset($__attributesOriginalabddde62786fb871e8a66d2206a4e797); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalabddde62786fb871e8a66d2206a4e797)): ?>
<?php $component = $__componentOriginalabddde62786fb871e8a66d2206a4e797; ?>
<?php unset($__componentOriginalabddde62786fb871e8a66d2206a4e797); ?>
<?php endif; ?>

    <div class="flex items-center gap-2">
        <div class="relative w-full">
            <iconify-icon class="<?php echo e($iconClass); ?>"
                icon="<?php echo e(match ($type) {
                    'email' => 'mdi:email',
                    'password' => 'mdi:password',
                    'number' => 'tabler:number-123',
                    'search' => 'ion:search-sharp',
                    'address' => 'mdi:address-marker',
                    'person' => 'mdi:user',
                    'idcard' => 'mingcute:idcard-fill',
                    'phone' => 'mdi:phone',
                    'mobile' => 'basil:mobile-phone-outline',
                    'postcode' => 'material-symbols:local-post-office-rounded',
                    'time' => 'lineicons:alarm-clock',
                    default => $icon,
                }); ?>"></iconify-icon>

            <!--[if BLOCK]><![endif]--><?php if($type === 'textarea'): ?>
                <textarea id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                    <?php if($model): ?> wire:model.live.debounce.1000ms="<?php echo e($model); ?>" <?php endif; ?>
                    placeholder="<?php echo e($placeholder); ?>" autocomplete="<?php echo e($name); ?>"
                    <?php echo e($attributes->merge([
                        'class' => implode(
                            ' ' . [
                                'w-full py-3 pl-10 pr-3 input input-bordered min-h-40 focus:outline-none focus:ring-2 focus:ring-neutral disabled:disabled',
                                !empty($errorMessages) ? 'border-error focus:ring-error' : '',
                            ],
                        ),
                        'disabled' => $disabled,
                        'autofocus' => $autofocus,
                        'required' => $required,
                        'maxlength' => $max,
                        'pattern' => $pattern,
                    ])); ?>

                    aria-describedby="<?php echo e($name); ?>-error"></textarea>
            <?php elseif($type === 'date'): ?>
                <input id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" type="<?php echo e($type); ?>"
                    <?php if($model): ?> wire:model.live="<?php echo e($model); ?>" <?php endif; ?>
                    placeholder="<?php echo e($placeholder); ?>" autocomplete="<?php echo e($name); ?>"
                    <?php echo e($attributes->merge([
                        'class' =>
                            'w-full pl-10 input input-bordered focus:outline-none focus:ring-2 focus:ring-neutral disabled:disabled' .
                            (empty($errorMessages) ? '' : ' border-error focus:ring-error'),
                        'disabled' => $disabled,
                        'autofocus' => $autofocus,
                        'required' => $required,
                        'max' => $max,
                        'min' => $min,
                        'step' => $step,
                        'pattern' => $pattern,
                    ])); ?>

                    aria-describedby="<?php echo e($name); ?>-error">
            <?php else: ?>
                <input id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" type="<?php echo e($type); ?>"
                    <?php if($model): ?> wire:model.live.debounce.1000ms="<?php echo e($model); ?>" <?php endif; ?>
                    placeholder="<?php echo e($placeholder); ?>" autocomplete="<?php echo e($name); ?>"
                    <?php echo e($attributes->merge([
                        'class' =>
                            'w-full pl-10 input input-bordered focus:outline-none focus:ring-2 focus:ring-neutral disabled:disabled' .
                            (empty($errorMessages) ? '' : ' border-error focus:ring-error'),
                        'disabled' => $disabled,
                        'autofocus' => $autofocus,
                        'required' => $required,
                        'max' => $max,
                        'min' => $min,
                        'step' => $step,
                        'pattern' => $pattern,
                    ])); ?>

                    aria-describedby="<?php echo e($name); ?>-error">
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($unit): ?>
            <span class="text-sm font-medium text-gray-500"><?php echo e($unit); ?></span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!--[if BLOCK]><![endif]--><?php if($messages && !$hideMessages): ?>
        <div>
            <?php if (isset($component)) { $__componentOriginalcfef9ae9d181bd9f9c23f131244452e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcfef9ae9d181bd9f9c23f131244452e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-error','data' => ['class' => 'mt-2','messages' => $messages]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($messages)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcfef9ae9d181bd9f9c23f131244452e1)): ?>
<?php $attributes = $__attributesOriginalcfef9ae9d181bd9f9c23f131244452e1; ?>
<?php unset($__attributesOriginalcfef9ae9d181bd9f9c23f131244452e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcfef9ae9d181bd9f9c23f131244452e1)): ?>
<?php $component = $__componentOriginalcfef9ae9d181bd9f9c23f131244452e1; ?>
<?php unset($__componentOriginalcfef9ae9d181bd9f9c23f131244452e1); ?>
<?php endif; ?>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/forms/input-text.blade.php ENDPATH**/ ?>