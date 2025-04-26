<div class="px-8 wh-full">
    <?php if (isset($component)) { $__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stepbar','data' => ['currentStep' => '1','steps' => '4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stepbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['currentStep' => '1','steps' => '4']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0)): ?>
<?php $attributes = $__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0; ?>
<?php unset($__attributesOriginal8409bfce3af0b2dbdf42828f1fb2f3d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0)): ?>
<?php $component = $__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0; ?>
<?php unset($__componentOriginal8409bfce3af0b2dbdf42828f1fb2f3d0); ?>
<?php endif; ?>

    <div class="max-w-4xl mx-auto space-y-16 wh-full">
        <div class="flex flex-col max-w-4xl gap-4 mx-auto text-center">
            <h1 class="text-heading-lg">Konfigurasi Data Sekolah</h1>
            <p>Silakan isi data umum sekolah yang akan menggunakan sistem ini. Informasi ini akan menjadi identitas
                utama yang muncul di seluruh tampilan dan fitur aplikasi.</p>
        </div>

        <div>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('schools.school-form', ['key' => \App\Helpers\Helper::key('school-form')]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1997890591-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>

        <div class="flex items-center justify-end w-full gap-4">
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
            <?php if (isset($component)) { $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.submit','data' => ['form' => 'school_form']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => 'school_form']); ?>Lanjut <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $attributes = $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $component = $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/installations/pages/install-school.blade.php ENDPATH**/ ?>