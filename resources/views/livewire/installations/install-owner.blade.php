<div class="wh-full">
    <div class="flex flex-col text-center justify-center">
        <h1 class="text-heading-lg">Buat Akun Administrator</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit maxime maiores laborum nihil expedita
            voluptatem vero ullam voluptate qui incidunt. Quo perspiciatis velit sit eum dignissimos aliquid voluptate
            ea officia.</p>
    </div>

    <div>
        @livewire('auth.register-owner-form', [], key(App\Helpers\Helper::key('register-owner-form')))
    </div>

    <div class="flex justify-end gap-4 items-center">
        <x-button class="btn-ghost">Kembali</x-button>
        <x-form.submit form="register-owner-form">Daftar</x-form.submit>
    </div>
</div>
