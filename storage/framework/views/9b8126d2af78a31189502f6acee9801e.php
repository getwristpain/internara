<?php $__env->startSection('body'); ?>
    <?php if (isset($component)) { $__componentOriginale401d7c46fb0a119c511a4f79b41c60d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale401d7c46fb0a119c511a4f79b41c60d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.bg-decoration','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('bg-decoration'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale401d7c46fb0a119c511a4f79b41c60d)): ?>
<?php $attributes = $__attributesOriginale401d7c46fb0a119c511a4f79b41c60d; ?>
<?php unset($__attributesOriginale401d7c46fb0a119c511a4f79b41c60d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale401d7c46fb0a119c511a4f79b41c60d)): ?>
<?php $component = $__componentOriginale401d7c46fb0a119c511a4f79b41c60d; ?>
<?php unset($__componentOriginale401d7c46fb0a119c511a4f79b41c60d); ?>
<?php endif; ?>

    <div class="flex flex-col wh-full">
        <div class="w-full">
            <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
        </div>

        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/layouts/guest.blade.php ENDPATH**/ ?>