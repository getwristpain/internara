<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'attributes' => [],
    'name' => '',
    'show' => '',
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
    'name' => '',
    'show' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div id="<?php echo e($name); ?>" x-cloak x-data="{
    show: <?php if ((object) ($show) instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($show->value()); ?>')<?php echo e($show->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e($show); ?>')<?php endif; ?>.live,
    closeModal() {
        this.show = false;
        $dispatch('modal-closed', { name: '<?php echo e($name); ?>' });
    }
}" x-init="show = false" x-show="show"
    :class="{ 'fixed top-0 left-0 z-10': show }">
    <div
        class="fixed top-0 left-0 z-10 flex items-center justify-center p-8 overflow-x-hidden overflow-y-auto bg-black wh-screen scrollbar-hidden bg-opacity-20 backdrop-blur-sm">
        <div class="relative w-full max-w-4xl bg-white h-fit min-h-12 rounded-xl" @click.away="closeModal()"
            @keydown.window.escape="closeModal()">
            <div class="flex flex-col w-full overflow-y-visible">
                <div class="relative flex items-center justify-end gap-4 px-8 py-4 font-bold bg-gray-100 rounded-t-xl">
                    <!--[if BLOCK]><![endif]--><?php if(isset($header)): ?>
                        <div class="flex-1 w-full flex gap-2 items-center">
                            <?php echo e($header); ?>

                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="group">
                        <button class="btn btn-circle btn-sm bg-gray-200 group-hover:bg-gray-300 basic-transition"
                            @click="closeModal()">
                            <iconify-icon class="font-bold text-gray-600 basic-transition group-hover:text-red-600"
                                icon="mdi:close"></iconify-icon>
                        </button>
                    </div>
                </div>

                <div class="p-8">
                    <?php echo e($body ?? $slot); ?>

                </div>

                <!--[if BLOCK]><![endif]--><?php if(isset($footer)): ?>
                    <div class="flex items-center justify-end gap-4 px-8 py-4 bg-gray-100 rounded-b-xl">
                        <?php echo e($footer); ?>

                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/modal.blade.php ENDPATH**/ ?>