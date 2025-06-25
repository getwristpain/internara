<?php
    $system = app(\App\Services\SystemService::class)->getAttributes();
?>

<!DOCTYPE html>
<html data-theme="light" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8">
        <meta name="author" content="<?php echo e($author ?? ''); ?>">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="description" content="<?php echo e($description ?? ''); ?>">
        <meta name="keywords" content="<?php echo e($keywords ?? ''); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Title -->
        <title><?php echo e($title ?? $system->name); ?></title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo e($favicon ?? asset($system->logo_path)); ?>" type="image/x-icon">

        <!-- Vite Configs -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

        <?php echo $__env->yieldPushContent('head'); ?>
    </head>

    <body>
        <?php echo $__env->yieldContent('body'); ?>

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>

</html>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/layouts/app.blade.php ENDPATH**/ ?>