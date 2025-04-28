<div class="wh-full p-8">
    <div class="w-full max-w-lg mx-auto flex flex-col gap-12">
        <div class="border p-8 rounded-xl shadow-lg bg-white">
            <?php if (isset($component)) { $__componentOriginalf9a5f060e1fbbcbc7beb643b113b10ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf9a5f060e1fbbcbc7beb643b113b10ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form','data' => ['name' => 'forgot-password-form','submit' => 'recoverPassword']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'forgot-password-form','submit' => 'recoverPassword']); ?>
                 <?php $__env->slot('header', null, []); ?> 
                    <div class="text-center space-y-1">
                        <h2 class="text-heading-lg">Lupa Kata Sandi</h2>
                        <p>Masukkan email anda untuk mengatur ulang kata sandi</p>
                    </div>
                 <?php $__env->endSlot(); ?>
                 <?php $__env->slot('body', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginal262894a2c291df91ae9f7b925bf8a923 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal262894a2c291df91ae9f7b925bf8a923 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-text','data' => ['type' => 'email','name' => 'email','model' => 'email','label' => 'Email','placeholder' => 'Masukkan email anda','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'email','name' => 'email','model' => 'email','label' => 'Email','placeholder' => 'Masukkan email anda','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $attributes = $__attributesOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__attributesOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal262894a2c291df91ae9f7b925bf8a923)): ?>
<?php $component = $__componentOriginal262894a2c291df91ae9f7b925bf8a923; ?>
<?php unset($__componentOriginal262894a2c291df91ae9f7b925bf8a923); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>

                 <?php $__env->slot('footer', null, []); ?> 
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['class' => 'btn-outline btn-neutral','action' => 'back']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-outline btn-neutral','action' => 'back']); ?>Batal <?php echo $__env->renderComponent(); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Kirim Email Pemulihan <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $attributes = $__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__attributesOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1)): ?>
<?php $component = $__componentOriginal115b46fcdf6e9400520dc8007e7b99a1; ?>
<?php unset($__componentOriginal115b46fcdf6e9400520dc8007e7b99a1); ?>
<?php endif; ?>
                 <?php $__env->endSlot(); ?>
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
        </div>
    </div>
</div><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/auth/pages/forgot-password.blade.php ENDPATH**/ ?>