<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'allowCreate' => false,
    'autofocus' => false,
    'badge' => '',
    'disabled' => false,
    'hideError' => false,
    'hint' => null,
    'label' => null,
    'model' => '',
    'name' => '',
    'options' => '',
    'placeholder' => 'Select or create an option...',
    'required' => false,
    'searchbar' => false,
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
    'allowCreate' => false,
    'autofocus' => false,
    'badge' => '',
    'disabled' => false,
    'hideError' => false,
    'hint' => null,
    'label' => null,
    'model' => '',
    'name' => '',
    'options' => '',
    'placeholder' => 'Select or create an option...',
    'required' => false,
    'searchbar' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $badgeClass = match ($badge) {
        'primary' => 'badge badge-primary',
        'secondary' => 'badge badge-secondary',
        'neutral' => 'badge badge-neutral',
        'success' => 'badge badge-success',
        'info' => 'badge badge-info',
        'warning' => 'badge badge-warning',
        'error' => 'badge badge-error',
        'ghost' => 'badge badge-ghost',
        'outline-neutral' => 'badge badge-outline badge-neutral',
        default => '',
    };
?>

<div class="flex flex-col gap-2 w-full font-medium pt-1 <?php echo e($disabled ? 'disabled' : ''); ?>">
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

        <div class="relative w-full" x-data="{
            open: false,
            search: '',
            selected: <?php if ((object) ($model) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($model->value()); ?>')<?php echo e($model->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($model); ?>')<?php endif; ?>.live,
            options: <?php if ((object) ($options) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($options->value()); ?>')<?php echo e($options->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($options); ?>')<?php endif; ?>.live,
            allowCreate: <?php echo \Illuminate\Support\Js::from($allowCreate)->toHtml() ?>,
            showSearch: <?php echo \Illuminate\Support\Js::from($searchbar)->toHtml() ?>,
            filteredOptions() {
                return this.options.filter(opt => opt.label.toLowerCase().includes(this.search.toLowerCase()));
            },
            isCreatingNew() {
                return this.allowCreate && this.search.trim() !== '' && this.filteredOptions().length === 0;
            },
            addOption() {
                if (this.isCreatingNew()) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('<?php echo e($options); ?>', [...window.Livewire.find('<?php echo e($_instance->getId()); ?>').get('<?php echo e($options); ?>'), { value: this.search, label: this.search }]);
                    this.selected = this.search;
                    this.open = false;
                    this.search = '';
                }
            }
        }">
            <div class="flex w-full gap-2 items-center justify-between cursor-pointer input input-bordered focus:ring-2 focus:ring-neutral <?php echo e($disabled ? 'opacity-80 cursor-not-allowed' : ''); ?>"
                @click="if (!<?php echo e($disabled ? 'true' : 'false'); ?>) { open = !open }" tabindex="0">
                <iconify-icon class="text-gray-400 scale-125" icon="tabler:selector"></iconify-icon>
                <span class="flex-1 text-gray-500 <?php echo e($badgeClass); ?> text-nowrap" style="font-size: inherit;"
                    x-text="filteredOptions().find(option => option.value === selected)?.label || '<?php echo e($placeholder); ?>'"></span>
                <svg class="inline w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div class="absolute z-50 w-full mt-1 bg-white border rounded-md" x-show="open" @click.away="open = false"
                tabindex="0">
                <!-- Search Input -->
                <template x-if="showSearch">
                    <input class="w-full p-2 border rounded-t-md" type="text" x-model="search"
                        placeholder="<?php echo e('Cari ' . $placeholder); ?>" style="font-size: inherit;"
                        <?php echo e($disabled ? 'disabled' : ''); ?> <?php echo e($required ? 'required' : ''); ?> autofocus tabindex="0" />
                </template>

                <!-- Options List -->
                <div class="max-h-60 overflow-y-auto">
                    <template x-for="option in filteredOptions()" :key="option.value">
                        <div class="p-2 cursor-pointer hover:bg-gray-100"
                            @click="if (!<?php echo e($disabled ? 'true' : 'false'); ?>) {
                            selected = option.value;
                            open = false;
                            search = '';
                        }"
                            tabindex="0">
                            <span x-text="option.label"></span>
                        </div>
                    </template>
                </div>

                <!-- Create New Option -->
                <template x-if="isCreatingNew()">
                    <div class="p-2 cursor-pointer hover:bg-gray-100" @click="addOption()" tabindex="0">
                        <span x-text="'Create new: ' + search"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php if($errors->has($model) && !$hideError): ?>
        <div class="mt-2">
            <?php if (isset($component)) { $__componentOriginalcfef9ae9d181bd9f9c23f131244452e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcfef9ae9d181bd9f9c23f131244452e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-error','data' => ['class' => 'mt-2','messages' => $errors->get($model)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get($model))]); ?>
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
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/forms/input-select.blade.php ENDPATH**/ ?>