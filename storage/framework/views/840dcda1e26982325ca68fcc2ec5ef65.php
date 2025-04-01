<div class="p-8 wh-full">
    <div class="flex flex-col max-w-4xl gap-12 mx-auto wh-full">
        <div class="flex flex-col justify-center gap-4 text-center">
            <h1 class="text-heading-lg">Buat Akun Administrator</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit maxime maiores laborum nihil expedita
                voluptatem vero ullam voluptate qui incidunt. Quo perspiciatis velit sit eum dignissimos aliquid
                voluptate
                ea officia.</p>
        </div>

        <div class="flex-1">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('auth.register-owner-form', []);

$__html = app('livewire')->mount($__name, $__params, App\Helpers\Helper::key('register-owner-form'), $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>

        <div class="flex items-center justify-end gap-4">
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['class' => 'btn-ghost','action' => 'back']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-ghost','action' => 'back']); ?>Kembali <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginale6e0844200c2004e3c6b4b3d3922d729 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6e0844200c2004e3c6b4b3d3922d729 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.submit','data' => ['form' => 'register-owner-form']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => 'register-owner-form']); ?>Buat Akun <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale6e0844200c2004e3c6b4b3d3922d729)): ?>
<?php $attributes = $__attributesOriginale6e0844200c2004e3c6b4b3d3922d729; ?>
<?php unset($__attributesOriginale6e0844200c2004e3c6b4b3d3922d729); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale6e0844200c2004e3c6b4b3d3922d729)): ?>
<?php $component = $__componentOriginale6e0844200c2004e3c6b4b3d3922d729; ?>
<?php unset($__componentOriginale6e0844200c2004e3c6b4b3d3922d729); ?>
<?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/installations/install-owner.blade.php ENDPATH**/ ?>