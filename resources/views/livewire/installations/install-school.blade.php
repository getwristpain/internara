<div class="max-w-4xl p-8 mx-auto space-y-16 wh-full">
    <div class="flex flex-col max-w-4xl gap-4 mx-auto text-center">
        <h1 class="text-heading-lg">Konfigurasi Data Sekolah</h1>
        <p>Silakan lengkapi informasi sekolah Anda untuk menyesuaikan aplikasi dengan kebutuhan institusi. Data ini akan
            digunakan untuk menampilkan identitas sekolah di berbagai fitur aplikasi.</p>
    </div>

    <div>
        @livewire('schools.school-form', ['key' => \App\Helpers\Helper::key('school-form')])
    </div>

    <div class="flex items-center justify-end w-full gap-4">
        <x-button class="btn-ghost" action="back">Kembali</x-button>
        <x-forms.submit form="school_form">Lanjut</x-forms.submit>
    </div>
</div>
