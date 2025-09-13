<div class="mx-auto flex w-full max-w-6xl flex-1 flex-col items-center justify-center gap-8 pt-12">
    <div class="w-full space-y-1 text-center">
        <x-ui.animate>
            <h1 class="text-head">
                Atur Jurusan Sekolah
            </h1>
        </x-ui.animate>

        <x-ui.animate delay="200ms">
            <p class="text-subhead">
                Tambah dan kurang jurusan sekolah Anda dengan fleksibel.
            </p>
        </x-ui.animate>
    </div>

    <x-ui.animate class="w-full flex-1" delay="400ms">
        @livewire('departments.department-list')
    </x-ui.animate>

    <x-ui.animate class="flex w-full items-center justify-end" delay="200ms">
        <x-ui.button class="btn-wide" label="Lanjutkan" wire:click="next" color="primary" loading="next" shadowed />
    </x-ui.animate>
</div>
