# User Flow – Internara (Revisi MVP Final)

## Owner/Admin

### Instalasi (Application Setup)

* Admin membuka `/setup`.
* Welcome page menampilkan langkah instalasi.
* Admin membuat akun **admin pertama** (role: `admin` + `owner`, status `protected`).
* Admin mengisi data sekolah → menambahkan jurusan → menambahkan daftar program PKL.
* Setelah selesai → aplikasi ditandai `installed` → diarahkan ke `/login`.
* Middleware:
  * Jika aplikasi **belum `installed`**, semua akses diarahkan ke `/setup`.
  * Jika aplikasi sudah `installed`, hanya halaman login & public yang terbuka.

### Login

* Admin login dengan email & password → diarahkan ke `/admin`.
* Hanya `admin`/`owner` yang bisa mengakses panel admin.

### Verifikasi Registrasi & Penempatan Siswa

* Admin melihat daftar siswa `pending-verification`.
* Memvalidasi:
  * Profil siswa → status `Active`.
  * Penempatan PKL → jika valid, siswa siap diverifikasi.
* Status akhir siswa → `Verified` setelah diverifikasi.

### Monitoring Penugasan & Penilaian PKL

* Admin memantau upload **Laporan PKL** & **PPT Presentasi**.
* Memverifikasi status tugas: `submitted`, `approved`, atau `revision`.
* Admin dapat **mengunci hasil penilaian** → status siswa menjadi `graduated`.
* Admin dapat mengunduh rekap nilai seluruh siswa (PDF/Excel).
* Sistem mengirim notifikasi ke Teacher/Supervisor ketika siswa upload tugas.

---

## Student

### Registrasi & Aktivasi

* Siswa membuka `/register` → buat akun → otomatis login (`student`, status `pending-activation`).
* Middleware `CheckUserStatus`:
  * Jika `pending-activation` → redirect ke `/internship/registration`.
* Di `/internship/registration`, siswa:
  * Lengkapi profil (nisn, kontak, dll).
  * Pilih program PKL aktif.
  * Pilih penempatan tersedia atau ajukan penempatan baru.
* Submit → status `Active`.
* Admin memverifikasi → status siswa menjadi `Verified`.

### Dashboard Siswa

* Lihat status akun (`Active` / `Verified`) dan progres PKL.
* Lihat status tugas (laporan & PPT).
* Dashboard menampilkan reminder upload tugas dan status review.
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

* Review **Laporan PKL** & **PPT Presentasi** → beri status `approved` / `revision`.
* Memberi catatan tambahan jika diperlukan.

### Penilaian Siswa

* Mengisi form penilaian siswa bimbingan:
  * Kedisiplinan, keterampilan teknis, komunikasi, etika kerja, laporan & presentasi.
* Status penilaian: `not-evaluated`, `in-progress`, `evaluated`.
* Hasil penilaian tersimpan di sistem.

---

## Supervisor (Pembimbing Industri)

### Login & Dashboard

* Supervisor login dengan akun dibuat oleh Admin → diarahkan ke dashboard `/supervisor`.
* Lihat daftar siswa yang ditempatkan di perusahaannya.

### Monitoring Penugasan

* Supervisor dapat melihat upload **Laporan PKL** & **PPT Presentasi** siswa.
* Memberi feedback/catatan tambahan untuk kualitas laporan.
* Persetujuan Supervisor bersifat **opsional**.

### Penilaian Siswa (Opsional)

* Supervisor dapat mengisi penilaian tambahan terkait performa siswa di lapangan.
* Status penilaian: `not-evaluated` / `evaluated`.
* Nilai Supervisor digabungkan dengan nilai Teacher jika tersedia.

### Laporan Rekap Evaluasi

* Supervisor dapat mengakses rekap evaluasi siswa yang ditempatkan di perusahaannya.
* Bisa diunduh untuk arsip internal industri (opsional).
