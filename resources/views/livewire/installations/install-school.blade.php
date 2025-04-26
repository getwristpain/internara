<div class="px-8 wh-full">
    <x-stepbar currentStep="1" steps="4"></x-stepbar>

    <div class="max-w-4xl mx-auto space-y-16 wh-full">
        <div class="flex flex-col max-w-4xl gap-4 mx-auto text-center">
            <h1 class="text-heading-lg">Konfigurasi Data Sekolah</h1>
            <p>Silakan isi data umum sekolah yang akan menggunakan sistem ini. Informasi ini akan menjadi identitas
                utama yang muncul di seluruh tampilan dan fitur aplikasi.</p>
        </div>

        <div>
            @livewire('schools.school-form', ['key' => \App\Helpers\Helper::key('school-form')])
        </div>

        <div class="flex items-center justify-end w-full gap-4">
            <x-button class="btn-ghost" action="back">Kembali</x-button>
            <x-forms.submit form="school_form">Lanjut</x-forms.submit>
        </div>
    </div>
</div>
