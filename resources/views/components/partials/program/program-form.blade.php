@props([
    'action' => 'add',
    'submit' => 'submit',
])

@php
    $title = $action === 'add' ? 'Tambah Program' : 'Edit Program';
    $desc =
        $action === 'add'
            ? 'Isi form berikut untuk menambahkan program baru.'
            : 'Sesuaikan detail program.';
@endphp

<x-form class="w-full" name="programForm" :$submit :$title :$desc>
    <div class="flex w-full flex-col">
        <x-input.text field="form.data.title" label="Judul Program"
            placeholder="Masukkan judul program..." required />
        <x-input.text type="textarea" field="form.data.description"
            label="Deskripsi" placeholder="Masukkan deskripsi program..." />
        <div class="flex w-full gap-x-4">
            <x-input.text type="year" field="form.data.year" label="Tahun"
                placeholder="Tahun" required />
            <x-input.select field="form.data.semester"
                options="form.options.semester" label="Semester"
                placeholder="Ganjil / Genap" required />
        </div>
        <div class="flex w-full gap-x-4 max-sm:flex-col">
            <x-input.text type="date" field="form.data.date_start"
                label="Tanggal Mulai" required />
            <x-input.text type="date" field="form.data.date_end"
                label="Tanggal Selesai" required />
        </div>
    </div>
</x-form>
