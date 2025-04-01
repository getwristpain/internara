<div class="w-full">
    <?php if (isset($component)) { $__componentOriginalf9a5f060e1fbbcbc7beb643b113b10ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf9a5f060e1fbbcbc7beb643b113b10ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form','data' => ['name' => 'register-owner-form','submit' => 'registerOwner']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'register-owner-form','submit' => 'registerOwner']); ?>
        <?php if (isset($component)) { $__componentOriginalec8317d4b42b6916a726c612ebf39f70 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec8317d4b42b6916a726c612ebf39f70 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'name','name' => 'owner_name','model' => 'owner.name','label' => 'Nama Lengkap','placeholder' => 'Masukkan nama lengkap...','required' => true,'autofocus' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'name','name' => 'owner_name','model' => 'owner.name','label' => 'Nama Lengkap','placeholder' => 'Masukkan nama lengkap...','required' => true,'autofocus' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'email','name' => 'owner_email','model' => 'owner.email','label' => 'Email','placeholder' => 'mail@example.com','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','name' => 'owner_email','model' => 'owner.email','label' => 'Email','placeholder' => 'mail@example.com','required' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'password','name' => 'owner_password','model' => 'owner.password','label' => 'Kata Sandi','placeholder' => 'Masukkan kata sandi...','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'owner_password','model' => 'owner.password','label' => 'Kata Sandi','placeholder' => 'Masukkan kata sandi...','required' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.forms.input-text','data' => ['type' => 'password','name' => 'owner_password_confirmation','model' => 'owner.password_confirmation','label' => 'Konfirmasi Kata Sandi','placeholder' => 'Konfirmasi kata sandi...','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('forms.input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'password','name' => 'owner_password_confirmation','model' => 'owner.password_confirmation','label' => 'Konfirmasi Kata Sandi','placeholder' => 'Konfirmasi kata sandi...','required' => true]); ?>
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
<?php endif; ?>
</div><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/auth/register-owner-form.blade.php ENDPATH**/ ?>