<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'app_name' => config('app.name', 'Internara'),
    'app_version' => config('app.version', '1.0.0'),
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
    'app_name' => config('app.name', 'Internara'),
    'app_version' => config('app.version', '1.0.0'),
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

<div class="flex flex-col wh-full bg-primary md:flex-row">
    <div class="flex wh-full items-center justify-center relative rounded-b-[15%] md:rounded-none overflow-hidden">
        <div class="absolute wh-full bg-base-100">
            <span class="before:content-['']"></span>
        </div>
        <div class="z-10 w-full max-w-md">
            <img class="object-fill object-center w-full h-auto lg:scale-150"
                src="<?php echo e(asset('images/illustrations/teamworks/teamwork-5.svg')); ?>" alt="Teamwork Illustration">
        </div>
    </div>

    <div class="flex flex-col items-center justify-end p-8 wh-full md:justify-center lg:px-24">
        <div class="flex flex-col gap-4 md:max-w-sm md:wh-full md:justify-between lg:max-w-full">
            <div class="space-y-2">
                <p class="text-sm font-bold">INSTALASI APLIKASI</p>
                <h1 class="flex text-heading-xl">
                    Selamat Datang <br> di <?php echo e($app_name); ?>

                </h1>
                <p class="text-subheading">Kelola PKL Sekolah Lebih Mudah!</p>
                <p class="pt-6 text-justify">Internara membantu siswa, guru, dan pembimbing mengelola PKL secara
                    digital.
                    Pendaftaran, monitoring, dan penilaian kini lebih praktis dan terpusat.</p>
            </div>
            <div class="hidden h-full text-sm md:block lg:text-base">
                <ul class="space-y-2">
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
            <div
                class="flex flex-col items-center justify-center w-full gap-4 mt-8 lg:justify-start lg:flex-row-reverse">
                <button class="btn btn-neutral btn-wide" wire:click="next">
                    <span>Mulai Instalasi</span>
                    <span><iconify-icon icon="icon-park-outline:right-c"></iconify-icon></span>
                </button>
                <span class="text-sm font-medium text-gray-600"><?php echo e('Version ' . $app_version); ?></span>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/installations/install-welcome.blade.php ENDPATH**/ ?>