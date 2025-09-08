# User Flow - Internara

## Owner/Admin

### Instalasi (Application Setup)

* Admin membuka `/setup`.
* Welcome page menampilkan langkah instalasi.
* Admin membuat akun **admin** pertama (role: `admin` + `owner`, status `protected`).
* Admin mengisi data sekolah → menambahkan jurusan → menambahkan daftar program PKL.
* Setelah selesai → aplikasi ditandai `installed` → diarahkan ke `/login`.
* Middleware: jika belum `installed`, semua akses diarahkan ke `/setup`.

### Login

* Admin login dengan email & password → diarahkan ke `/admin`.
* Hanya `admin`/`owner` yang bisa mengakses panel admin.

### Verifikasi Registrasi & Penempatan Siswa

* Admin melihat daftar siswa `pending-verification`.
* Memvalidasi profil siswa dan penempatan PKL.
* Status valid → siswa menjadi `active`.

### Monitoring Penugasan & Penilaian PKL

* Admin memantau upload **laporan PKL** & **PPT presentasi**.
* Memverifikasi status: `submitted`, `approved`, atau `revision`.
* Admin dapat mengunci hasil penilaian → status siswa menjadi `graduated`.
* Admin dapat mengunduh rekap nilai seluruh siswa (PDF/Excel).

---

## Student

### Registrasi & Aktivasi

* Siswa membuka `/register` → buat akun → otomatis login (`student`, status `pending-activation`).
* Middleware `CheckUserStatus`: jika `pending-activation` → redirect ke `/internship/registration`.
* Di `/internship/registration`, siswa:

  * Lengkapi profil (nisn, kontak, dll).
  * Pilih program PKL aktif dan penempatan tersedia.
* Submit → status `pending-verification`.
* Admin verifikasi → status siswa `active`.

### Dashboard Siswa

* Lihat status akun dan progres PKL.
* Lihat status tugas (laporan & PPT).
* Tombol logout.

### Penugasan Akhir PKL

* Upload **Laporan PKL** (PDF/DOCX) & **PPT Presentasi**.
* Sistem validasi file (format, ukuran).
* Status tugas: `submitted`, `approved`, `revision`.
* Dashboard menampilkan reminder upload & status review.

### Penilaian PKL

* Siswa melihat nilai dari Teacher (wajib) dan Supervisor (opsional).
* Ringkasan nilai & status penilaian tersedia di dashboard.
* Siswa dapat mengunduh **rapor PKL** (PDF).

---

## Teacher (Guru Pembimbing)

### Dashboard Teacher

* Lihat daftar siswa bimbingan dan status penugasan & penilaian.
* Notifikasi tugas yang perlu diverifikasi.

### Monitoring Penugasan

* Review **laporan PKL** & **PPT presentasi** → `approved` / `revision`.
* Memberi catatan tambahan jika diperlukan.

### Penilaian Siswa

* Mengisi form penilaian untuk siswa bimbingan (kedisiplinan, keterampilan teknis, komunikasi, etika kerja, laporan & presentasi).
* Status penilaian: `not-evaluated`, `in-progress`, `evaluated`.
* Hasil penilaian tersimpan di sistem.

---

## Supervisor (Pembimbing Industri)

### Login & Dashboard

* Supervisor login dengan akun yang dibuat oleh Admin → diarahkan ke dashboard `/supervisor`.
* Lihat daftar siswa yang ditempatkan di perusahaan.

### Monitoring Penugasan

* Supervisor dapat melihat upload **laporan PKL** & **PPT presentasi** siswa.
* Memberi feedback/catatan tambahan untuk kualitas laporan.
* Persetujuan Supervisor bersifat **opsional**, untuk memastikan laporan sesuai standar industri.

### Penilaian Siswa (Opsional)

* Supervisor dapat mengisi penilaian tambahan terkait performa siswa di lapangan.
* Status penilaian: `not-evaluated` / `evaluated`.
* Nilai Supervisor digabungkan dengan nilai Teacher jika tersedia.

### Laporan Rekap Evaluasi

* Supervisor dapat mengakses rekap evaluasi siswa yang ditempatkan di perusahaannya.
* Bisa diunduh untuk arsip internal industri (opsional).

---

⚡ **Catatan MVP:**

* Fokus utama tetap: **pendaftaran PKL → pengumpulan tugas (laporan & PPT) → penilaian PKL**.
* Supervisor hadir untuk **feedback dan penilaian opsional**, mendukung validasi industri.
