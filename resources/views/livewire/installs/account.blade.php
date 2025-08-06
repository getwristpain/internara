<div class="wh-full flex gap-16 p-16 justify-center items-center" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
    <div class="w-full" x-show="show" x-transition:enter="transition duration-700 ease-out delay-400"
        x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
        @livewire('forms.register', ['type' => 'owner', 'bordered' => true, 'shadowed' => true])
    </div>
    <div class="space-y-16 w-full">
        <div class="space-y-4">
            <h1 class="text-4xl font-black" x-show="show" x-transition:enter="transition duration-700 ease-out"
                x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                Buat
                Akun Administrator</h1>
            <p class="text-xl text-neutral-600" x-show="show"
                x-transition:enter="transition duration-700 ease-out delay-200"
                x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
                Kelola data sistem secara penuh untuk menyiapkan masa depan siswa.</p>
        </div>
        <div x-show="show" x-transition:enter="transition duration-700 ease-out delay-400"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0">
            <x-button class="btn-wide btn-lg" type="submit" label="Buat Akun" form="register-form" />
        </div>
    </div>
</div>
