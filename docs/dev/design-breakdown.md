# App Design Breakdown

## User Flow – Owner/Admin

### Instalasi (Application Setup)

* Admin sekolah membuka `/setup`.
* Tampil welcome page berisi langkah instalasi.
* Admin membuat akun **admin** pertama, otomatis diberi role `admin` + `owner` + status `protected`.
* Admin mengisi data awal sekolah → menambahkan jurusan → menambahkan daftar program PKL.
* Setelah selesai, aplikasi ditandai `installed`.
* Sistem mengarahkan ke `/login`.
* Middleware:

  * Jika belum `installed`, semua akses diarahkan ke `/setup`.
  * Jika sudah `installed`, hanya halaman login & public yang terbuka.

### Login

* Admin masuk dengan email & password.
* Role `admin` otomatis diarahkan ke `/admin`.
* Hanya role `admin` dan `owner` yang bisa akses panel admin.
* Middleware autentikasi wajib.
* Tidak ada registrasi eksternal untuk role admin.

### Manajemen Pengguna

* Menu ini **hanya muncul untuk `owner`**.
* `Owner` dapat menambah, edit, dan hapus pengguna.
* Akun `owner` tidak bisa diedit maupun dihapus.
* Akun selain `owner` saat dibuat akan berstatus `pending-activation`.
* Tambahkan policy untuk mencegah penghapusan `owner`.

### Verifikasi Registrasi Siswa

* Admin melihat daftar siswa dengan status `pending-verification`.
* Admin memvalidasi data profil siswa (nisn, alamat, kontak, dll).
* Jika valid → status siswa berubah menjadi `active`.
* Jika tidak valid → siswa diminta memperbaiki data.

### Verifikasi Penempatan Siswa

* Admin memantau daftar penempatan dari siswa.
* Admin memverifikasi penempatan:

  * Jika valid → ditandai `verified`.
  * Jika siswa mengajukan penempatan baru → admin menambahkan data perusahaan baru.
* Admin menetapkan penempatan yang sah untuk siswa.

### Monitoring Jurnal

* Admin dapat mengakses rekap seluruh jurnal siswa.
* Admin memantau siapa yang sudah/tidak mengisi jurnal.
* Admin tidak menyetujui jurnal, hanya berfungsi sebagai pengawas.
* Rekap jurnal dapat diunduh sebagai laporan.

### Verifikasi Penugasan Akhir

* Admin memantau upload laporan PKL & PPT dari siswa.
* Admin menandai status upload:

  * `submitted` → menunggu review.
  * `approved` → valid.
  * `rejected/revision` → siswa wajib upload ulang.
* Setelah laporan & PPT valid, status siswa otomatis menjadi `completed`.

### Penilaian PKL

* Admin memantau progress penilaian.
* Admin memverifikasi bahwa seluruh siswa sudah dinilai.
* Admin dapat **mengunci hasil penilaian** agar tidak bisa diubah lagi.
* Setelah nilai dikunci, status siswa menjadi `graduated`.
* Admin dapat mengunduh rekap nilai seluruh siswa (Excel/PDF).

---

## User Flow - Student

### Registrasi & Aktivasi

* Siswa membuka `/register` → buat akun → otomatis login.
* Akun diberi role `student` + status `pending-activation`.
* Middleware `CheckUserStatus`:

  * Jika `pending-activation`, redirect ke `/internship/registration`.
* Di `/internship/registration`, siswa:

  * Lengkapi profil (avatar, nisn, alamat, kontak darurat, dll).
  * Pilih program PKL aktif.
  * Pilih penempatan tersedia atau ajukan baru.
* Setelah submit → status tetap `pending-verification` (belum aktif).
* Sistem arahkan kembali ke `/dashboard` (tapi fitur terbatas, hanya bisa lihat status & edit data).
* Admin memverifikasi data → jika valid, status jadi `active`.
* Setelah verifikasi akhir → status `verified`.

### Dashboard Siswa

* Lihat status akun (pending, active, verified).
* Lihat rangkuman profil, program PKL, penempatan, jurnal kegiatan, nilai.
* Tombol logout.

### Penempatan & Verifikasi

* Setelah daftar, siswa menunggu admin memverifikasi penempatan.
* Admin:

  * Cek apakah penempatan valid/tersedia.
  * Tambah guru pembimbing (teacher) & pembimbing industri (supervisor).
  * Tandai penempatan sebagai `verified`.

### Jurnal Kegiatan PKL

* Menu `Jurnal Kegiatan`.
* Siswa isi: hari/tanggal, kompetensi dasar, topik pekerjaan, nilai karakter harian.
* Guru pembimbing wajib menyetujui, supervisor opsional.
* Persetujuan kolektif (sekali approve untuk semua entry).
* Dashboard menampilkan reminder jika ada jurnal kosong.

### Jurnal Bimbingan PKL

* Menu `Pembimbingan`.
* Siswa isi: hari/tanggal, materi bimbingan, kesan/pesan.
* Guru pembimbing wajib menyetujui, supervisor opsional.
* Persetujuan kolektif.
* Reminder di dashboard jika ada jurnal kosong.

### Penugasan Akhir PKL

* Menu `Penugasan`.
* Upload Laporan PKL:
  * Siswa wajib mengunggah **Laporan PKL** (PDF/DOCX).
  * Sistem validasi file (ukuran, format).
  * Status tugas: `submitted`, `approved`, atau `rejected/revision`.
  * Guru pembimbing memeriksa dan memberi keputusan.
* Upload PPT Presentasi:
  * Siswa wajib mengunggah file PPT ringkasan laporan.
  * Validasi file (ukuran, format .ppt/.pptx).
  * Status tugas: `submitted`, `approved`, atau `rejected/revision`.
  * Guru pembimbing memeriksa dan memberi keputusan.
* Dashboard Reminder:
  * Dashboard menampilkan status progres penugasan (belum upload, menunggu review, perlu revisi, selesai).
  * Notifikasi muncul jika deadline mendekat.
* Verifikasi Penugasan:
  * Admin atau guru pembimbing menandai laporan & PPT sebagai valid.
  * Hanya setelah laporan & PPT disetujui, siswa bisa lanjut ke tahap **penilaian akhir**.
* Status akhir siswa: `completed` → jika semua tugas (jurnal, laporan, PPT) diverifikasi.

### Laporan Penilaian PKL

* Menu `Penilaian`.
* Komponen Penilaian:
  * Nilai dari **Guru Pembimbing (teacher)**.
  * Nilai dari **Pembimbing Industri (supervisor)**.
  * Komponen penilaian dapat meliputi: kedisiplinan, keterampilan teknis, etika kerja, komunikasi, dan hasil laporan PKL.
* Proses Penilaian:
  * Guru pembimbing wajib mengisi form penilaian.
  * Pembimbing industri opsional, tetapi jika tersedia nilainya akan digabungkan.
  * Sistem menghitung nilai akhir (misalnya: rata-rata, bobot tertentu, atau sesuai kebijakan sekolah).
* Status Penilaian:
  * `not-evaluated` → belum ada penilaian.
  * `in-progress` → sebagian penilaian sudah masuk.
  * `evaluated` → seluruh penilaian sudah lengkap.
* Laporan Penilaian:
  * Hasil penilaian ditampilkan pada dashboard siswa dalam bentuk ringkasan.
  * Siswa dapat mengunduh **rapor PKL** (PDF) yang berisi detail nilai, komentar guru, dan status kelulusan.
* Verifikasi Penilaian:
  * Admin dapat mengunci penilaian agar tidak bisa diubah lagi.
  * Setelah penilaian terkunci, status akhir siswa ditandai sebagai `graduated` (lulus PKL).

---

## User Flow – Teacher (Guru Pembimbing)

### Login Teacher

* Teacher login dengan akun yang dibuat oleh Admin.
* Setelah login → diarahkan ke dashboard `/teacher`.
* Tidak ada halaman registrasi (akun teacher dikelola penuh oleh Admin).

### Dashboard Teacher

* Ringkasan siswa bimbingan (list berdasarkan kelas/jurusan).
* Status siswa (penempatan, jurnal, penugasan, penilaian).
* Notifikasi tugas yang harus diverifikasi.

### Monitoring Jurnal Siswa

* Teacher melihat jurnal harian siswa bimbingannya.
* Dapat melakukan **review**:

  * `approved` → jurnal disetujui.
  * `revision` → siswa harus memperbaiki isi jurnal.
* Rekap jurnal bisa difilter berdasarkan siswa, tanggal, atau status.

### Monitoring Penugasan

* Teacher memantau upload **laporan PKL** & **PPT presentasi**.
* Dapat melakukan **review**:

  * `approved` → file valid.
  * `revision` → siswa wajib upload ulang.
* Teacher memberi catatan tambahan untuk perbaikan jika diperlukan.

### Penilaian Siswa

* Teacher melakukan penilaian akhir siswa.
* Komponen penilaian: kedisiplinan, keterampilan teknis, komunikasi, etika kerja, laporan PKL, dan presentasi.
* Penilaian bersifat **wajib** dari Teacher.
* Status penilaian:

  * `not-evaluated` → belum dinilai.
  * `in-progress` → sebagian aspek sudah dinilai.
  * `evaluated` → seluruh aspek sudah lengkap.
* Hasil penilaian tersimpan di sistem dan ikut dalam perhitungan nilai akhir siswa.

### Laporan Rekap

* Teacher dapat melihat dan mengunduh rekap penilaian & jurnal siswa bimbingan.
* Rekap bisa diekspor ke PDF/Excel untuk laporan ke sekolah.

---

## User Flow – Supervisor (Pembimbing Industri)

### Login Supervisor

* Supervisor login dengan akun yang telah dibuat oleh Admin.
* Setelah login → diarahkan ke dashboard `/supervisor`.
* Tidak ada halaman registrasi untuk Supervisor.

### Dashboard Supervisor

* Ringkasan siswa yang ditempatkan di perusahaan/industri tempat Supervisor bertugas.
* Status siswa (penempatan, jurnal, penugasan, penilaian).
* Notifikasi tugas yang harus diverifikasi.

### Monitoring Jurnal PKL Siswa

* Supervisor dapat melihat jurnal kegiatan harian siswa.
* Dapat memberikan persetujuan (`approved`) atau catatan (`revision`).
* Persetujuan Supervisor bersifat **opsional** (pendukung), sedangkan Teacher tetap **wajib**.
* Rekap jurnal dapat difilter berdasarkan siswa atau periode waktu.

### Monitoring Penugasan Siswa

* Supervisor dapat melihat upload **laporan PKL** & **PPT presentasi** siswa.
* Supervisor bisa memberikan feedback/catatan tambahan untuk kualitas laporan.
* Persetujuan Supervisor bersifat **opsional**, hanya untuk memastikan laporan relevan dengan dunia industri.

### Penilaian/Evaluasi Siswa

* Supervisor dapat memberikan penilaian tambahan terkait performa siswa di lapangan.
* Komponen penilaian: kedisiplinan, keterampilan kerja, kerjasama tim, etika profesi, dan sikap di tempat kerja.
* Penilaian Supervisor bersifat **opsional** (pelengkap), namun sangat penting untuk validasi dari sisi industri.
* Status penilaian:

  * `not-evaluated` → belum ada penilaian.
  * `evaluated` → penilaian sudah lengkap.

### Laporan Rekap Evaluasi

* Supervisor dapat mengakses rekap evaluasi siswa yang dibimbing di perusahaannya.
* Rekap ini hanya menampilkan siswa yang ditempatkan di bawah tanggung jawab Supervisor tersebut.
* Supervisor dapat mengunduh laporan sebagai arsip internal industri (opsional).
