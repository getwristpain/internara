<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'label' => null,
    'messages' => [],
    'model' => '',
    'name' => '',
    'placeholder' => 'Unggah Berkas',
    'required' => false,
    'preview' => null,
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
    'disabled' => false,
    'hideMessages' => false,
    'hint' => null,
    'label' => null,
    'messages' => [],
    'model' => '',
    'name' => '',
    'placeholder' => 'Unggah Berkas',
    'required' => false,
    'preview' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $messages = !empty($messages) ? $messages : (!empty($model) && $errors->has($model) ? $errors->get($model) : []);
    $hasErrors = !empty($messages);
    $borderColor = $hasErrors ? 'border-red-500' : 'border-gray-300';
?>

<div class="space-y-2 font-medium" x-data="{
    preview: null,
    initImage: <?php if ((object) ($preview) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($preview->value()); ?>')<?php echo e($preview->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($preview); ?>')<?php endif; ?> ?? <?php if ((object) ($model) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($model->value()); ?>')<?php echo e($model->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($model); ?>')<?php endif; ?>,
    init() {
        if (!this.preview && this.initImage) {
            this.preview = this.initImage;
        }
    },
    updatePreview(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = (e) => this.preview = e.target.result;
            reader.readAsDataURL(file);
        }
    }
}">
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

    <div <?php echo e($attributes->merge([
        'class' => implode(' ', [
            'flex flex-col items-center justify-center w-full gap-2 border rounded-lg min-h-4 p-4',
            $borderColor,
            $disabled ? ' disabled' : '',
        ]),
        'disabled' => 'disabled',
    ])); ?>

        wire:loading.class="loading-disabled" wire:target="<?php echo e($model); ?>">

        <!-- Hidden File Input -->
        <input
            <?php echo e($attributes->merge([
                'class' => 'hidden ' . ($disabled ? 'disabled' : ''),
                'disabled' => $disabled,
                'id' => $name,
                'name' => $name,
                'type' => 'file',
            ])); ?>

            wire:model="<?php echo e($model); ?>" x-ref="fileInput" @change="updatePreview($event)">

        <!-- Drop Area -->
        <div class="basic-transition bg-gray-100 border-4 border-dashed rounded-lg cursor-pointer hover:bg-gray-200 relative"
            @click="$refs.fileInput.click()">
            <div class="wh-full p-4">
                <template x-if="preview">
                    <img class="object-cover h-24" :src="preview" alt="<?php echo e($label); ?>">
                </template>
                <template x-if="!preview">
                    <?php if (isset($component)) { $__componentOriginald8df7172a1dcf52e21a74bcdceb15e43 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-media','data' => ['class' => 'h-24 opacity-40']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-24 opacity-40']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43)): ?>
<?php $attributes = $__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43; ?>
<?php unset($__attributesOriginald8df7172a1dcf52e21a74bcdceb15e43); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8df7172a1dcf52e21a74bcdceb15e43)): ?>
<?php $component = $__componentOriginald8df7172a1dcf52e21a74bcdceb15e43; ?>
<?php unset($__componentOriginald8df7172a1dcf52e21a74bcdceb15e43); ?>
<?php endif; ?>
                </template>
            </div>

            <div class="absolute top-0 isset-0 wh-full bg-white bg-opacity-75" wire:loading
                wire:target="<?php echo e($model); ?>">
                <div class="flex items-center justify-center gap-2 wh-full">
                    <span class="loading loading-spinner"></span>
                </div>
            </div>
        </div>

        <!--[if BLOCK]><![endif]--><?php if($hasErrors && !$hideMessages): ?>
            <div>
                <?php if (isset($component)) { $__componentOriginalcfef9ae9d181bd9f9c23f131244452e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcfef9ae9d181bd9f9c23f131244452e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-error','data' => ['messages' => $messages]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($messages)]); ?> <?php echo $__env->renderComponent(); ?>
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
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/forms/input-image.blade.php ENDPATH**/ ?>