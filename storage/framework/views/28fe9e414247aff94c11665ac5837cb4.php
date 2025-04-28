<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'features' => [
        [
            'title' => 'Pendaftaran PKL',
            'icon' => 'mdi:clipboard-text',
            'description' => 'Siswa mendaftar PKL online, memilih tempat, dan admin menyetujui atau menolak.',
        ],
        [
            'title' => 'Monitoring & Laporan',
            'icon' => 'mdi:notebook-edit',
            'description' => 'Siswa unggah laporan, guru beri feedback, dan upload bukti kehadiran.',
        ],
        [
            'title' => 'Penilaian & Sertifikat',
            'icon' => 'mdi:school',
            'description' => 'Pembimbing menilai siswa, sistem merekap nilai, dan sertifikat bisa diunduh.',
        ],
    ],
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'features' => [
        [
            'title' => 'Pendaftaran PKL',
            'icon' => 'mdi:clipboard-text',
            'description' => 'Siswa mendaftar PKL online, memilih tempat, dan admin menyetujui atau menolak.',
        ],
        [
            'title' => 'Monitoring & Laporan',
            'icon' => 'mdi:notebook-edit',
            'description' => 'Siswa unggah laporan, guru beri feedback, dan upload bukti kehadiran.',
        ],
        [
            'title' => 'Penilaian & Sertifikat',
            'icon' => 'mdi:school',
            'description' => 'Pembimbing menilai siswa, sistem merekap nilai, dan sertifikat bisa diunduh.',
        ],
    ],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="flex flex-col gap-8 p-8 wh-full lg:flex-row">
    <div class="flex items-center justify-center flex-1 w-full p-8">
        <img class="w-full h-auto max-w-sm mx-auto scale-150 lg:-translate-y-1/4"
            src="<?php echo e(asset('images/illustrations/teamworks/teamwork-5.svg')); ?>" alt="Teamwork Illustration">
    </div>
    <div class="flex flex-col justify-between w-full max-w-2xl gap-8 mx-auto">
        <div class="w-full space-y-4 text-center lg:text-left lg:mx-0">
            <span class="hidden font-medium text-gray-400 lg:block">Selamat Datang!</span>
            <h1 class="text-3xl tracking-wider text-heading">Siapkan Langkah untuk Menjelajah Masa Depan</h1>
            <p class="text-lg">Bimbing siswa menapaki dunia kerja dengan sistem yang mendukung langkah mereka.</p>
        </div>
        <div class="flex-col flex-1 hidden md:flex">
            <ul class="flex flex-col h-full gap-4 justify-evenly">
                <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-center">
                        <div class="px-4 py-2">
                            <iconify-icon class="text-4xl" icon="<?php echo e($feature['icon']); ?>"></iconify-icon>
                        </div>
                        <div class="w-full">
                            <p class="font-bold"><?php echo e($feature['title']); ?></p>
                            <p><?php echo e($feature['description']); ?></p>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="flex flex-col items-center justify-center w-full gap-4">
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['class' => 'shadow-lg btn-primary btn-wide','action' => 'next','icon' => 'icon-park-outline:right-c','reverse' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'shadow-lg btn-primary btn-wide','action' => 'next','icon' => 'icon-park-outline:right-c','reverse' => true]); ?>Mulai Instalasi <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <span class="text-sm font-medium"><?php echo e('Versi ' . $system['version']); ?></span>
        </div>
    </div>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/installations/pages/install-welcome.blade.php ENDPATH**/ ?>