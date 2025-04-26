<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'messages' => [],
    'styles' => [
        'alert' => [
            'info' => [
                'class' => 'alert alert-info',
                'icon' => 'mdi:information-outline',
            ],
            'success' => [
                'class' => 'alert alert-success',
                'icon' => 'mdi:check-circle-outline',
            ],
            'warning' => [
                'class' => 'alert alert-warning',
                'icon' => 'mdi:alert-outline',
            ],
            'error' => [
                'class' => 'alert alert-error',
                'icon' => 'mdi:close-circle-outline',
            ],
            'default' => [
                'class' => 'alert',
                'icon' => 'mdi:message-alert-outline',
            ],
        ],
        'cta' => [
            'info' => 'btn btn-info btn-sm',
            'succes' => 'btn btn-success btn-sm',
            'warning' => 'btn btn-warning btn-sm',
            'error' => 'btn btn-error btn-sm',
            'default' => 'btn btn-sm',
        ],
    ],
    'component' => [
        'class' => 'font-medium',
    ],
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
    'messages' => [],
    'styles' => [
        'alert' => [
            'info' => [
                'class' => 'alert alert-info',
                'icon' => 'mdi:information-outline',
            ],
            'success' => [
                'class' => 'alert alert-success',
                'icon' => 'mdi:check-circle-outline',
            ],
            'warning' => [
                'class' => 'alert alert-warning',
                'icon' => 'mdi:alert-outline',
            ],
            'error' => [
                'class' => 'alert alert-error',
                'icon' => 'mdi:close-circle-outline',
            ],
            'default' => [
                'class' => 'alert',
                'icon' => 'mdi:message-alert-outline',
            ],
        ],
        'cta' => [
            'info' => 'btn btn-info btn-sm',
            'succes' => 'btn btn-success btn-sm',
            'warning' => 'btn btn-warning btn-sm',
            'error' => 'btn btn-error btn-sm',
            'default' => 'btn btn-sm',
        ],
    ],
    'component' => [
        'class' => 'font-medium',
    ],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if(!empty($messages)): ?>
    <div <?php echo e($attributes->merge(['class' => 'w-full space-y-4'])); ?>>
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                if (is_string($message)) {
                    $text = $message;
                    $status = 'default';
                    $action = null;
                    $actionText = null;
                } else {
                    $text = $message['text'] ?? '';
                    $status = $message['status'] ?? 'default';
                    $action = $message['action'] ?? null;
                    $actionText = $message['actionText'] ?? null;
                }

                $alertStyle = $styles['alert'][$status] ?? $styles['alert']['default'];
                $ctaStyle = $styles['cta'][$status] ?? $styles['cta']['default'];
            ?>

            <div class="flex <?php echo e($component['class']); ?> <?php echo e($alertStyle['class']); ?>">
                <iconify-icon class="scale-110" icon="<?php echo e($alertStyle['icon']); ?>"></iconify-icon>
                <span><?php echo e($text); ?></span>
                <?php if(isset($action) && isset($actionText)): ?>
                    <button class="ml-auto <?php echo e($ctaStyle); ?>"
                        wire:click.prevent="<?php echo e($action); ?>"><?php echo e($actionText); ?></button>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/alerts.blade.php ENDPATH**/ ?>