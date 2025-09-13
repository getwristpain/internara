@props([
    'action' => 'add',
    'submit' => 'submit',
])

@php
    $title = $action === 'add' ? 'Tambah Program' : 'Edit Program';
    $desc = $action === 'add' ? 'Isi form berikut untuk menambahkan program baru.' : 'Sesuaikan detail program.';
@endphp

<x-ui.form class="w-full" name="programForm" :$submit :$title :$desc>
    <div class="grid grid-cols-2 gap-x-4">
        <x-ui.field class="col-span-full" field="form.data.title" label="Judul Program"
            placeholder="Masukkan judul program..." required />
        <x-ui.field class="col-span-full" type="textarea" field="form.data.description" label="Deskripsi"
            placeholder="Masukkan deskripsi program..." />
        <x-ui.field type="year" field="form.data.year" label="Tahun" placeholder="Tahun" required />
        <x-ui.field type="select" field="form.data.semester" options="form.options.semester" label="Semester"
            placeholder="Ganjil / Genap" required />
        <x-ui.field type="date" field="form.data.date_start" label="Tanggal Mulai" required />
        <x-ui.field type="date" field="form.data.date_end" label="Tanggal Selesai" required />
    </div>
</x-ui.form>
