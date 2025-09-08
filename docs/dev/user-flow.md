# User Flow – Internara

## Admin / Owner

### Instalasi (Application Setup)

* Admin membuka `/setup`.
* Welcome page menampilkan langkah instalasi.
* Admin membuat akun **Admin pertama** (role: `admin` + `owner`, status `protected`).
* Admin mengisi data sekolah → menambahkan jurusan → menambahkan program PKL.
* Setelah selesai → aplikasi ditandai `installed` → diarahkan ke `/login`.
* Middleware:

  * Jika aplikasi **belum `installed`**, semua akses diarahkan ke `/setup`.
  * Jika sudah `installed`, hanya halaman login & public yang terbuka.

### Login

* Admin login dengan email & password → diarahkan ke `/admin`.
* Hanya `admin`/`owner` yang bisa mengakses panel Admin.

### Verifikasi Registrasi & Penempatan Student

* Admin melihat daftar Student `pending-verification`.
* Memvalidasi:

  * Profil → status Student berubah menjadi `Active`.
  * Penempatan PKL → jika valid, Student siap diverifikasi.
* Status akhir Student → `Verified` setelah diverifikasi.

### Monitoring Penugasan & Penilaian PKL

* Admin memantau upload **Laporan PKL** & **PPT Presentasi** Student.
* Memverifikasi status tugas: `submitted`, `approved`, `revision`.
* Admin dapat **mengunci hasil penilaian** → status Student menjadi `graduated`.
* Admin dapat mengunduh rekap nilai seluruh Student (PDF/Excel).
* Sistem mengirim notifikasi ke Teacher dan Supervisor saat Student upload tugas.

---

## Student

### Registrasi & Aktivasi

* Student membuka `/register` → buat akun → otomatis login (`student`, status `pending-activation`).
* Middleware `CheckUserStatus`:

  * Jika `pending-activation` → redirect ke `/internship/registration`.
* Di `/internship/registration`, Student:

  * Lengkapi profil (nisn, kontak, dll) → status menjadi `Active`.
  * Pilih program PKL aktif.
  * Pilih penempatan tersedia atau ajukan penempatan baru.
* Admin memverifikasi → status Student menjadi `Verified`.

### Dashboard Student

* Lihat status akun (`Active` / `Verified`) dan progres PKL.
* Lihat status tugas (Laporan PKL & PPT).
* Dashboard menampilkan reminder upload & status review.
* Tombol logout.

### Penugasan Akhir PKL

* Upload **Laporan PKL** (PDF/DOCX) & **PPT Presentasi**.
* Sistem validasi file (format, ukuran).
* Status tugas: `submitted`, `approved`, `revision`.
* Dashboard menampilkan reminder dan status review.

### Penilaian PKL

* Student melihat nilai dari **Teacher** dan **Supervisor** (kedua penilaian **wajib**).
* Ringkasan nilai & status penilaian tersedia di dashboard.
* Student dapat mengunduh **rapor PKL** (PDF).

---

## Teacher

### Dashboard Teacher

* Lihat daftar Student bimbingan dan status penugasan & penilaian.
* Notifikasi tugas yang perlu diverifikasi.

### Monitoring Penugasan

* Review **Laporan PKL** & **PPT Presentasi** → beri status `approved` / `revision`.
* Memberi catatan tambahan jika diperlukan.

### Penilaian Student

* Mengisi form penilaian Student bimbingan:

  * Kedisiplinan, keterampilan teknis, komunikasi, etika kerja, Laporan PKL & PPT.
* Status penilaian: `not-evaluated`, `in-progress`, `evaluated`.
* Hasil penilaian tersimpan di sistem.

---

## Supervisor

### Login & Dashboard

* Supervisor login dengan akun dibuat oleh Admin → diarahkan ke dashboard `/supervisor`.
* Lihat daftar Student yang ditempatkan di perusahaan.

### Monitoring Penugasan

* Supervisor wajib **melihat upload Laporan PKL & PPT** Student.
* Memberi feedback/catatan tambahan untuk kualitas laporan.
* Persetujuan Supervisor bersifat **wajib**.

### Penilaian Student

* Supervisor wajib mengisi penilaian terkait performa Student di lapangan.
* Status penilaian: `not-evaluated` / `evaluated`.
* Nilai Supervisor digabungkan dengan nilai Teacher untuk perhitungan akhir.

### Laporan Rekap Evaluasi

* Supervisor dapat mengakses rekap evaluasi Student yang ditempatkan di perusahaannya.
* Bisa diunduh untuk arsip internal industri (opsional).
