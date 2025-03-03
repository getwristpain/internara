<!DOCTYPE html>
<html data-theme="light" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <!-- Title -->
        <title><?php echo e($title ?? config('app.name', 'Internara')); ?></title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="<?php echo e($favicon ?? asset(config('app.logo', 'images/logo.png'))); ?>"
            type="image/x-icon">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>

    <body>
        <?php echo e($slot); ?>

    </body>

</html>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>