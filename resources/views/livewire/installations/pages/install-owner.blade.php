<div class="px-8 wh-full">
    <x-stepbar currentStep="3" steps="4"></x-stepbar>
    <div class="flex flex-col max-w-4xl gap-12 mx-auto wh-full">
        <div class="flex flex-col justify-center gap-4 text-center">
            <h1 class="text-heading-lg">Buat Akun Administrator</h1>
            <p>Silakan buat akun utama yang akan memiliki akses penuh terhadap seluruh fitur aplikasi. Akun ini akan
                berperan sebagai pengelola utama sistem.</p>
        </div>

        <div class="flex-1">
            @livewire('auth.components.register-owner-form')
        </div>

        <div class="flex items-center justify-end gap-4 pb-8">
            <x-button class="btn-ghost" action="back">Kembali</x-button>
            <x-submit class="shadow-lg" form="register-owner-form">Buat Akun</x-submit>
        </div>
    </div>
</div>
