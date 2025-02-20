<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'options' => '',
    'disabled' => false,
    'help' => '',
    'label' => '',
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
    'options' => '',
    'disabled' => false,
    'help' => '',
    'label' => '',
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

<div class="w-full space-y-2">
    <!--[if BLOCK]><![endif]--><?php if($label): ?>
        <label class="<?php echo e($required ? 'required' : ''); ?> <?php echo e($disabled ? 'disabled opacity-100' : ''); ?>">
            <span><?php echo e($label); ?></span>
            <!--[if BLOCK]><![endif]--><?php if($help): ?>
                <span class="pl-1 text-gray-500">(<?php echo e($help); ?>)</span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </label>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="space-y-4">
        <div class="layout-cols">
            <?php if (isset($component)) { $__componentOriginal0005bf01aa83ec4ca92674161039a6ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-select','data' => ['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_province')).'','name' => ''.e($name . '_province').'','model' => ''.e($model . '.province_id').'','options' => ''.e($options . '.provinces').'','placeholder' => 'Provinsi','required' => $required,'searchbar' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_province')).'','name' => ''.e($name . '_province').'','model' => ''.e($model . '.province_id').'','options' => ''.e($options . '.provinces').'','placeholder' => 'Provinsi','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'searchbar' => true]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $attributes = $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $component = $__componentOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal0005bf01aa83ec4ca92674161039a6ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-select','data' => ['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_regency')).'','name' => ''.e($name . '_regency').'','model' => ''.e($model . '.regency_id').'','options' => ''.e($options . '.regencies').'','placeholder' => 'Kabupaten/Kota','required' => $required,'searchbar' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_regency')).'','name' => ''.e($name . '_regency').'','model' => ''.e($model . '.regency_id').'','options' => ''.e($options . '.regencies').'','placeholder' => 'Kabupaten/Kota','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'searchbar' => true]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $attributes = $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $component = $__componentOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal0005bf01aa83ec4ca92674161039a6ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-select','data' => ['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_district')).'','name' => ''.e($name . '_district').'','model' => ''.e($model . '.district_id').'','options' => ''.e($options . '.districts').'','placeholder' => 'Kecamatan','required' => $required,'searchbar' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_district')).'','name' => ''.e($name . '_district').'','model' => ''.e($model . '.district_id').'','options' => ''.e($options . '.districts').'','placeholder' => 'Kecamatan','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'searchbar' => true]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $attributes = $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $component = $__componentOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
        </div>

        <div class="items-center layout-cols">
            <?php if (isset($component)) { $__componentOriginal0005bf01aa83ec4ca92674161039a6ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-select','data' => ['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_village')).'','name' => ''.e($name . '_village').'','model' => ''.e($model . '.village_id').'','options' => ''.e($options . '.villages').'','placeholder' => 'Desa/Kelurahan','required' => $required,'searchbar' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e(\App\Helpers\Helper::key('input_select_village')).'','name' => ''.e($name . '_village').'','model' => ''.e($model . '.village_id').'','options' => ''.e($options . '.villages').'','placeholder' => 'Desa/Kelurahan','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required),'searchbar' => true]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $attributes = $__attributesOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__attributesOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca)): ?>
<?php $component = $__componentOriginal0005bf01aa83ec4ca92674161039a6ca; ?>
<?php unset($__componentOriginal0005bf01aa83ec4ca92674161039a6ca); ?>
<?php endif; ?>
            <div class="flex w-full gap-4">
                <div class="flex-1">
                    <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['wire:key' => ''.e(\App\Helpers\Helper::key('input_text_street')).'','type' => 'text','name' => ''.e($name . '_street').'','model' => ''.e($model . '.street').'','placeholder' => 'RT/RW/Nama Jalan/Nomor Bangunan (Opsional)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e(\App\Helpers\Helper::key('input_text_street')).'','type' => 'text','name' => ''.e($name . '_street').'','model' => ''.e($model . '.street').'','placeholder' => 'RT/RW/Nama Jalan/Nomor Bangunan (Opsional)']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
                </div>
                <div class="w-1/3">
                    <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['wire:key' => ''.e(\App\Helpers\Helper::key('input_text_postal_code')).'','type' => 'number','name' => ''.e($name . '_postal_code').'','model' => ''.e($model . '.postal_code').'','placeholder' => 'Kode Pos','required' => $required]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => ''.e(\App\Helpers\Helper::key('input_text_postal_code')).'','type' => 'number','name' => ''.e($name . '_postal_code').'','model' => ''.e($model . '.postal_code').'','placeholder' => 'Kode Pos','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($required)]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/input-address.blade.php ENDPATH**/ ?>