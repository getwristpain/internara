<div class="max-w-4xl p-8 mx-auto space-y-16 wh-full">
    <div class="flex flex-col max-w-4xl gap-4 mx-auto text-center">
        <h1 class="text-heading-lg">Konfigurasi Data Sekolah</h1>
        <p>Silakan lengkapi informasi sekolah Anda untuk menyesuaikan aplikasi dengan kebutuhan institusi. Data ini akan
            digunakan untuk menampilkan identitas sekolah di berbagai fitur aplikasi.</p>
    </div>

    <div>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.schools.school-form');

$__html = app('livewire')->mount($__name, $__params, \App\Helpers\Helper::key('school-form'), $__slots ?? [], get_defined_vars());

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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['class' => 'btn-ghost']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-ghost']); ?>Kembali <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal7fe032b346fffe6ecd9360d8e4db9a12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fe032b346fffe6ecd9360d8e4db9a12 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button-submit','data' => ['form' => 'school_form']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['form' => 'school_form']); ?>Lanjut <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7fe032b346fffe6ecd9360d8e4db9a12)): ?>
<?php $attributes = $__attributesOriginal7fe032b346fffe6ecd9360d8e4db9a12; ?>
<?php unset($__attributesOriginal7fe032b346fffe6ecd9360d8e4db9a12); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fe032b346fffe6ecd9360d8e4db9a12)): ?>
<?php $component = $__componentOriginal7fe032b346fffe6ecd9360d8e4db9a12; ?>
<?php unset($__componentOriginal7fe032b346fffe6ecd9360d8e4db9a12); ?>
<?php endif; ?>
    </div>
</div><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/pages/installations/school-setting.blade.php ENDPATH**/ ?>