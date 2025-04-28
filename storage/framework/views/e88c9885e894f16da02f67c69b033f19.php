<div class="px-8 wh-full">
    <?php if (isset($component)) { $__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stepbar','data' => ['currentStep' => '2','steps' => '4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stepbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['currentStep' => '2','steps' => '4']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0)): ?>
<?php $attributes = $__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0; ?>
<?php unset($__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0)): ?>
<?php $component = $__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0; ?>
<?php unset($__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0); ?>
<?php endif; ?>

    <div class="flex flex-col max-w-4xl gap-12 mx-auto wh-full">
        <div class="flex flex-col text-center">
            <h1 class="text-heading-lg">Jurusan dan Kelas</h1>
            <p>
                Masukkan daftar jurusan yang tersedia di sekolah beserta pembagian kelas di dalamnya. Jurusan akan
                menjadi pengelompokan utama bagi data siswa, sementara kelas membantu dalam pemetaan yang lebih detail.
            </p>
        </div>

        <div class="flex-1">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('departments.components.department-form');

$__html = app('livewire')->mount($__name, $__params, 'lw-1456133763-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>

        <div class="flex items-center justify-end gap-4 pb-8">
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
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['class' => 'btn-primary shadow-lg','action' => 'next','icon' => 'icon-park-outline:right-c','reverse' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-primary shadow-lg','action' => 'next','icon' => 'icon-park-outline:right-c','reverse' => true]); ?>Lanjut <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/installations/pages/install-department.blade.php ENDPATH**/ ?>