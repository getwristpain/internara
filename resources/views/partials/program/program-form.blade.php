@props([
    'submit' => '',
])

<x-form title="Tambah Program" desc="Isi form berikut untuk menambahkan program baru." name="programForm" :$submit>
    <div class="flex flex-col w-full">
        <x-input field="form.data.title" label="Judul Program" placeholder="Masukkan judul program..." required></x-input>
        <x-input type="textarea" field="form.data.description" label="Deskripsi"
            placeholder="Masukkan deskripsi program..."></x-input>
        <div class="flex gap-x-4 w-full">
            <x-input type="year" field="form.data.year" label="Tahun" placeholder="Tahun" required></x-input>
            <x-input type="select" field="form.data.semester" options="form.options.semester" label="Semester"
                placeholder="Ganjil / Genap" required></x-input>
        </div>
        <div class="flex max-sm:flex-col gap-x-4 w-full">
            <x-input type="date" field="form.data.date_start" label="Tanggal Mulai" required></x-input>
            <x-input type="date" field="form.data.date_end" label="Tanggal Selesai" required></x-input>
        </div>
    </div>
</x-form>
