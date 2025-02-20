<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'component' => [],
    'hideMessages' => false,
    'name' => '',
    'label' => '',
    'messages' => [],
    'model' => '',
    'placeholder' => 'Unggah Berkas',
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
    'component' => [],
    'hideMessages' => false,
    'name' => '',
    'label' => '',
    'messages' => [],
    'model' => '',
    'placeholder' => 'Unggah Berkas',
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
    $componentHasErrorsStyles = !empty($messages) ? 'border-red-500' : 'border-gray-300';
    $componentStyles = implode(' ', [$componentHasErrorsStyles, $component['styles'] ?? '']);
    $inputStyles = implode(' ', [$componentHasErrorsStyles, $component['inputStyles'] ?? '']);

    $messages = !empty($messages) ? $message : ($errors->has($model) ? $errors->get($model) : []);
?>

<div x-data="{
    preview: <?php if ((object) ($model) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($model->value()); ?>')<?php echo e($model->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($model); ?>')<?php endif; ?>.live,
    selectFile() {
        this.$refs.fileInput.click();
    },
    updatePreview(event) {
        const file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.preview = e.target.result;
                $wire.set('<?php echo e($model); ?>', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    }
}" <?php echo e($attributes->merge(['class' => 'space-y-2 font-medium'])); ?> x-cloak>
    <!--[if BLOCK]><![endif]--><?php if(isset($label)): ?>
        <label class="<?php echo e(!$required ?: 'required'); ?>" for="<?php echo e($name); ?>"><?php echo e($label); ?></label>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        class="flex flex-col items-center justify-center w-full gap-2 border rounded-lg min-h-4 p-4 <?php echo e($componentStyles); ?>">
        <!-- Hidden File Input -->
        <input class="hidden" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" <?php echo e($required); ?> type="file"
            x-ref="fileInput" @change="updatePreview" wire:model="<?php echo e($model); ?>">

        <div class="cursor-pointer hover:bg-gray-200 basic-transition border-4 border-dashed rounded-lg bg-gray-100 p-4 <?php echo e($inputStyles); ?>"
            @click="selectFile">
            <div>
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
        </div>

        <!--[if BLOCK]><![endif]--><?php if(!empty($messages) && !$hideMessages): ?>
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
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-image.blade.php ENDPATH**/ ?>