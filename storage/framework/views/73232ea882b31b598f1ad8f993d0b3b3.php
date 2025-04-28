<div class="px-8 pt-8 pb-24 wh-full">
    <div
        class="flex flex-col wh-full gap-12 max-w-4xl mx-auto bg-white rounded-xl bg-opacity-90 drop-shadow-lg shadow-sm shadow-neutral-300 p-8">
        <div class="flex flex-col items-center justify-center gap-12">
            <h1 class="text-heading-lg">Yeay, Instalasi Selesai! 🎉</h1>
            <p>
                Anda kini dapat masuk ke dalam dashboard menggunakan akun administrator yang telah dibuat. Mulailah
                dengan mengelola data siswa, menambahkan tempat PKL, dan memonitor seluruh aktivitas praktik kerja
                lapangan dengan lebih mudah dan terstruktur.
            </p>
        </div>
        <div class="flex-1 space-y-12">
            <div class="ml-12 space-y-4">
                <p>
                    Aplikasi ini dikembangkan oleh <b>Reas Vyn (@getwristpain)</b> sebagai kontribusi untuk mendukung
                    transformasi digital dalam dunia pendidikan.
                </p>
                <p>
                    Proyek ini dibuat dengan harapan dapat mempermudah guru, siswa, dan pihak sekolah dalam mengelola
                    kegiatan
                    PKL secara efektif.
                </p>
                <p>
                    Dukungan, saran, atau pelaporan bug dapat dikirimkan melalui kontak resmi atau langsung melalui
                    repositori
                    pengembangan.
                </p>
                <p>
                    Github Repositori: <a class="text-link"
                        href="https://github.com/getwristpain/internara"><i>github.com/getwristpain/internara</i></a>
                </p>
            </div>
            <div>
                <p>
                    Terima kasih telah menggunakan aplikasi ini. Kami berharap aplikasi ini bermanfaat dan terus
                    berkembang
                    seiring kebutuhan Anda.
                </p>
            </div>
        </div>
        <div class="flex items-center justify-end">
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['class' => 'btn-primary btn-wide shadow-lg','icon' => 'icon-park-outline:right-c','reverse' => true,'action' => 'next']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'btn-primary btn-wide shadow-lg','icon' => 'icon-park-outline:right-c','reverse' => true,'action' => 'next']); ?>Masuk Untuk
                Melanjutkan <?php echo $__env->renderComponent(); ?>
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

    <template x-teleport="<?php echo e('body'); ?>">
        <div class="fixed top-0 left-0 -z-10 wh-screen overflow-hidden">
            <img class="absolute inset-0 object-cover w-full h-full opacity-60"
                src="<?php echo e(asset('images/backgrounds/bg-congrate.png')); ?>" alt="Background">
        </div>
    </template>
</div>
<?php /**PATH /home/reasnovynt/Projects/apps/getwristpain/internara/resources/views/livewire/installations/pages/install-complete.blade.php ENDPATH**/ ?>