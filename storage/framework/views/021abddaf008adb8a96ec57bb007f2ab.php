<?php if (isset($component)) { $__componentOriginalf9a5f060e1fbbcbc7beb643b113b10ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf9a5f060e1fbbcbc7beb643b113b10ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form','data' => ['name' => 'school_form','submit' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'school_form','submit' => 'save']); ?>
    <?php if (isset($component)) { $__componentOriginal834dc4f5ef28006cdb373b4a93362343 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal834dc4f5ef28006cdb373b4a93362343 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-image','data' => ['name' => 'school_logo','model' => 'school.logo','preview' => 'school.logo_preview','label' => 'Logo Sekolah','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'school_logo','model' => 'school.logo','preview' => 'school.logo_preview','label' => 'Logo Sekolah','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal834dc4f5ef28006cdb373b4a93362343)): ?>
<?php $attributes = $__attributesOriginal834dc4f5ef28006cdb373b4a93362343; ?>
<?php unset($__attributesOriginal834dc4f5ef28006cdb373b4a93362343); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal834dc4f5ef28006cdb373b4a93362343)): ?>
<?php $component = $__componentOriginal834dc4f5ef28006cdb373b4a93362343; ?>
<?php unset($__componentOriginal834dc4f5ef28006cdb373b4a93362343); ?>
<?php endif; ?>

    <div class="layout-cols">
        <?php if (isset($component)) { $__componentOriginalec8317d4b42b6916a726c612ebf39f70 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec8317d4b42b6916a726c612ebf39f70 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['name' => 'school_name','model' => 'school.name','label' => 'Nama Sekolah','placeholder' => 'Masukkan nama sekolah...','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'school_name','model' => 'school.name','label' => 'Nama Sekolah','placeholder' => 'Masukkan nama sekolah...','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $attributes = $__attributesOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $component = $__componentOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__componentOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalec8317d4b42b6916a726c612ebf39f70 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec8317d4b42b6916a726c612ebf39f70 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'email','name' => 'school_email','model' => 'school.email','label' => 'Email Sekolah','placeholder' => 'mail@example.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','name' => 'school_email','model' => 'school.email','label' => 'Email Sekolah','placeholder' => 'mail@example.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $attributes = $__attributesOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $component = $__componentOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__componentOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
    </div>

    <?php if (isset($component)) { $__componentOriginal8da9fca9425887049bb0d776a1fa1a81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8da9fca9425887049bb0d776a1fa1a81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-address','data' => ['name' => 'school_address','model' => 'school.address','label' => 'Alamat Sekolah','options' => 'addressOptions']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-address'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'school_address','model' => 'school.address','label' => 'Alamat Sekolah','options' => 'addressOptions']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8da9fca9425887049bb0d776a1fa1a81)): ?>
<?php $attributes = $__attributesOriginal8da9fca9425887049bb0d776a1fa1a81; ?>
<?php unset($__attributesOriginal8da9fca9425887049bb0d776a1fa1a81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8da9fca9425887049bb0d776a1fa1a81)): ?>
<?php $component = $__componentOriginal8da9fca9425887049bb0d776a1fa1a81; ?>
<?php unset($__componentOriginal8da9fca9425887049bb0d776a1fa1a81); ?>
<?php endif; ?>

    <div class="layout-cols">
        <?php if (isset($component)) { $__componentOriginalec8317d4b42b6916a726c612ebf39f70 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec8317d4b42b6916a726c612ebf39f70 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'phone','name' => 'school_phone','model' => 'school.phone','label' => 'Telepon Sekolah','placeholder' => 'xxx xxxx-xxxx']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'phone','name' => 'school_phone','model' => 'school.phone','label' => 'Telepon Sekolah','placeholder' => 'xxx xxxx-xxxx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $attributes = $__attributesOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $component = $__componentOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__componentOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalec8317d4b42b6916a726c612ebf39f70 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec8317d4b42b6916a726c612ebf39f70 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'phone','name' => 'school_fax','model' => 'school.fax','label' => 'Fax. Sekolah','placeholder' => 'xxx xxxx-xxxx']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'phone','name' => 'school_fax','model' => 'school.fax','label' => 'Fax. Sekolah','placeholder' => 'xxx xxxx-xxxx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $attributes = $__attributesOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $component = $__componentOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__componentOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
    </div>

    <?php if (isset($component)) { $__componentOriginalec8317d4b42b6916a726c612ebf39f70 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec8317d4b42b6916a726c612ebf39f70 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'person','name' => 'school_principal_name','model' => 'school.principal_name','label' => 'Nama Kepala Sekolah','placeholder' => 'Masukkan nama kepala sekolah...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'person','name' => 'school_principal_name','model' => 'school.principal_name','label' => 'Nama Kepala Sekolah','placeholder' => 'Masukkan nama kepala sekolah...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $attributes = $__attributesOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__attributesOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec8317d4b42b6916a726c612ebf39f70)): ?>
<?php $component = $__componentOriginalec8317d4b42b6916a726c612ebf39f70; ?>
<?php unset($__componentOriginalec8317d4b42b6916a726c612ebf39f70); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf9a5f060e1fbbcbc7beb643b113b10ab)): ?>
<?php $attributes = $__attributesOriginalf9a5f060e1fbbcbc7beb643b113b10ab; ?>
<?php unset($__attributesOriginalf9a5f060e1fbbcbc7beb643b113b10ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf9a5f060e1fbbcbc7beb643b113b10ab)): ?>
<?php $component = $__componentOriginalf9a5f060e1fbbcbc7beb643b113b10ab; ?>
<?php unset($__componentOriginalf9a5f060e1fbbcbc7beb643b113b10ab); ?>
<?php endif; ?><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/schools/school-form.blade.php ENDPATH**/ ?>