<div class="mx-auto flex w-full max-w-2xl flex-1 flex-col justify-center gap-12 max-md:pt-12 lg:items-center">
    <div class="w-full space-y-1 text-center">
        <x-ui.animate>
            <h1 class="text-head">
                Buat Akun Administrator
            </h1>
        </x-ui.animate>

        <x-ui.animate delay="200ms">
            <p class="text-subhead">
                Kendalikan sistem dengan akun pusat untuk kelola data secara penuh.
            </p>
        </x-ui.animate>
    </div>

    <x-ui.animate class="w-full" delay="200ms">
        @livewire('auth.register-form', [
            'desc' => 'Akun ini digunakan sebagai akun pusat untuk mengelola seluruh data sistem.',
            'type' => 'owner',
            'bordered' => true,
            'shadowed' => true,
            'hideActions' => true,
        ])
    </x-ui.animate>

    <x-ui.animate class="flex w-full items-center justify-end gap-4">
        <x-ui.button label="Buat Akun" type="submit" form="registerForm" shadowed
            x-on:dirty-loading.window="loading = $event.detail.loading" />
    </x-ui.animate>
</div>
