<div class="p-8 wh-full">
    <div class="flex flex-col max-w-4xl gap-12 mx-auto wh-full">
        <div class="flex flex-col justify-center gap-4 text-center">
            <h1 class="text-heading-lg">Buat Akun Administrator</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit maxime maiores laborum nihil expedita
                voluptatem vero ullam voluptate qui incidunt. Quo perspiciatis velit sit eum dignissimos aliquid
                voluptate
                ea officia.</p>
        </div>

        <div class="flex-1">
            @livewire('auth.register-owner-form', [], key(App\Helpers\Helper::key('register-owner-form')))
        </div>

        <div class="flex items-center justify-end gap-4">
            <x-button class="btn-ghost" action="back">Kembali</x-button>
            <x-forms.submit form="register-owner-form">Buat Akun</x-forms.submit>
        </div>
    </div>
</div>
