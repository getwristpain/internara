@props([
    'name' => 'programForm',
    'submit' => 'submit',
    'title' => 'Tambah Program',
    'desc' => 'Buat program PKL baru.',
])

@php
    $edit = isset($program) && $program?->exists;

    $title = $edit ? 'Edit Program' : 'Tambah Program';
    $desc = $edit ? "(Program ID: {$program?->id} - {$program?->title})" : 'Buat program PKL baru.';
@endphp

<x-ui.form class="w-full" name="programForm" :$submit :$title :$desc>
    <div class="grid grid-cols-2 gap-x-4">
        <x-ui.field class="col-span-full" field="data.title" label="Judul Program" placeholder="Masukkan judul program..."
            required />
        <x-ui.field class="col-span-full" type="textarea" field="data.description" label="Deskripsi"
            placeholder="Masukkan deskripsi program..." />
        <x-ui.field type="year" field="data.year" label="Tahun" placeholder="Tahun" required />
        <x-ui.field type="select" field="data.semester" options="options.semester" label="Semester"
            placeholder="Ganjil / Genap" required />
        <x-ui.field type="date" field="data.date_start" label="Tanggal Mulai" required />
        <x-ui.field type="date" field="data.date_end" label="Tanggal Selesai" required />
    </div>

    <div class="flex w-full justify-end gap-4 pt-8">
        @if ($edit)
            <x-ui.button wire:click="remove" label="Hapus" icon="tabler:trash-filled" type="button" color="error"
                dirty="remove" shadowed />
        @endif

        <x-ui.button label="Simpan" type="submit" form="programForm" dirty="submit" shadowed />
    </div>
</x-ui.form>
