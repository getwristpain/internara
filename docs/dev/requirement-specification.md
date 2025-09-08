# Requirement Specification - Internara MVP

---

## 1. Latar Belakang

Pelaksanaan Program Praktik Kerja Lapangan (PKL) di sekolah sering menghadapi kendala dalam proses pendaftaran peserta, pengumpulan tugas, dan penilaian siswa. Proses pendaftaran masih dilakukan secara manual, pengumpulan laporan dan dokumen PKL tersebar dalam berbagai format, serta evaluasi siswa dilakukan berdasarkan laporan periodik yang tidak selalu tepat waktu. Hal ini menyebabkan beban administrasi yang tinggi bagi guru pembimbing, keterlambatan umpan balik untuk siswa, dan koordinasi yang kurang efektif dengan supervisor perusahaan. Selain itu, siswa sering kesulitan mengakses informasi penting mengenai PKL, seperti jadwal, tugas, dan hasil evaluasi, sehingga menghambat kelancaran proses belajar praktik.

Untuk mengatasi permasalahan tersebut, dibutuhkan sistem manajemen PKL yang terintegrasi, yang memungkinkan pendaftaran peserta secara mudah, pengumpulan tugas dan laporan secara digital, serta penilaian siswa yang dapat dilakukan secara real-time. Dengan sistem ini, administrasi PKL menjadi lebih efisien, guru pembimbing dapat fokus memberikan bimbingan dan evaluasi yang tepat, siswa menerima umpan balik lebih cepat, dan koordinasi antara sekolah dan mitra industri berjalan lebih optimal. Sistem manajemen PKL yang efektif diharapkan meningkatkan kualitas pelaksanaan PKL serta kesiapan siswa dalam menghadapi dunia kerja.

---

## 2. Tujuan

Tujuan utama pengembangan sistem Internara adalah untuk meningkatkan efisiensi dan efektivitas pengelolaan Program Praktik Kerja Lapangan (PKL) di tingkat sekolah dengan menyediakan platform terintegrasi untuk:

* Pendaftaran Peserta PKL – Memfasilitasi proses registrasi siswa secara digital, cepat, dan akurat.
* Pengumpulan Tugas dan Laporan PKL – Mengotomatisasi pengumpulan dokumen dan laporan, sehingga guru dan siswa tidak lagi terbebani oleh proses manual.
* Penilaian Siswa PKL – Memberikan mekanisme evaluasi yang real-time dan transparan, memungkinkan guru pembimbing dan supervisor memberikan umpan balik tepat waktu.

---

## 3. Manfaat

Penerapan sistem Internara diharapkan memberikan manfaat sebagai berikut:

* Efisiensi Administrasi – Mengurangi waktu dan tenaga yang dibutuhkan untuk pendaftaran peserta dan pengumpulan tugas PKL.
* Kualitas Pembimbingan Lebih Baik – Guru pembimbing dapat fokus memberikan evaluasi dan bimbingan karena beban administrasi berkurang.
* Transparansi dan Ketepatan Informasi – Siswa menerima informasi terkait pendaftaran, tugas, dan hasil penilaian secara jelas dan tepat waktu.
* Evaluasi Siswa Lebih Cepat dan Akurat – Umpan balik dari guru dan supervisor dapat diberikan secara tepat waktu, mendukung pengembangan keterampilan siswa secara optimal.

---

## 4. Functional Requirements (FR) - Internara MVP

| **Aktor / Fungsi**                   | **Fitur / FR**                                                 | **Prioritas** | **Keterangan**                                                                                 |
| ------------------------------------ | -------------------------------------------------------------- | ------------- | ---------------------------------------------------------------------------------------------- |
| **Admin / Owner**                    | Instalasi & Setup                                              | Must have     | Halaman `/setup`, buat akun pertama (`owner/admin`), input data sekolah, jurusan, program PKL. |
|                                      | Middleware akses sebelum install                               | Must have     | Mencegah akses halaman lain sebelum aplikasi terinstall.                                       |
|                                      | Verifikasi profil siswa                                        | Must have     | Memastikan data siswa valid sebelum `Verified`.                                                |
|                                      | Verifikasi penempatan siswa                                    | Must have     | Menyetujui atau menolak penempatan, termasuk penempatan baru yang diajukan siswa.              |
|                                      | Status siswa `Active` → `Verified`                             | Must have     | `Active`: sudah melengkapi data; `Verified`: sudah diverifikasi admin.                         |
|                                      | Monitoring penugasan & penilaian                               | Must have     | Memantau upload laporan & PPT siswa.                                                           |
|                                      | Admin mengunci hasil penilaian                                 | Must have     | Menetapkan nilai final siswa.                                                                  |
|                                      | Download rekap nilai siswa (PDF/Excel)                         | Should have   | Berguna untuk arsip, bisa ditunda di MVP.                                                      |
|                                      | Notifikasi ke Teacher/Supervisor                               | Should have   | Memberi tahu jika siswa upload tugas baru.                                                     |
| **Siswa**                            | Registrasi & Aktivasi                                          | Must have     | Membuat akun, melengkapi profil, memilih program PKL, memilih atau mengajukan penempatan baru. |
|                                      | Status `Pending-Activation` → `Active` → `Verified`            | Must have     | Menandakan siswa sudah siap untuk mengikuti workflow PKL.                                      |
|                                      | Upload Laporan PKL & PPT                                       | Must have     | Core workflow pengumpulan tugas PKL.                                                           |
|                                      | Validasi file (format & ukuran)                                | Must have     | Mencegah error file.                                                                           |
|                                      | Status tugas (`submitted`, `approved`, `revision`)             | Must have     | Mempermudah tracking progress tugas.                                                           |
|                                      | Dashboard reminder & status tugas                              | Should have   | Opsional, membantu siswa mengingat deadline.                                                   |
|                                      | Melihat nilai Teacher & Supervisor                             | Must have     | Transparansi nilai PKL.                                                                        |
|                                      | Download rapor PKL (PDF)                                       | Should have   | Bisa ditunda, berguna untuk dokumentasi siswa.                                                 |
| **Teacher / Guru Pembimbing**        | Monitoring penugasan siswa                                     | Must have     | Review laporan & PPT → beri status `approved` / `revision`.                                    |
|                                      | Memberi catatan perbaikan                                      | Should have   | Opsional untuk MVP, meningkatkan kualitas feedback.                                            |
|                                      | Penilaian akhir siswa                                          | Must have     | Kedisiplinan, keterampilan, komunikasi, etika, laporan & PPT.                                  |
|                                      | Status penilaian (`not-evaluated`, `in-progress`, `evaluated`) | Must have     | Mempermudah tracking penilaian siswa.                                                          |
|                                      | Status Teacher `Active` → `Verified`                           | Must have     | Teacher siap melakukan review & penilaian.                                                     |
|                                      | Download rekap penilaian & tugas (PDF/Excel)                   | Should have   | Opsional, bisa ditunda.                                                                        |
| **Supervisor / Pembimbing Industri** | Monitoring penugasan siswa                                     | Should have   | Lihat laporan & PPT → beri feedback opsional.                                                  |
|                                      | Penilaian tambahan siswa                                       | Could have    | Nilai tambahan untuk validasi industri, opsional di MVP.                                       |
|                                      | Rekap evaluasi siswa di perusahaan                             | Could have    | Opsional untuk arsip internal.                                                                 |
|                                      | Status Supervisor `Active` → `Verified`                        | Must have     | Supervisor siap memberikan feedback/penilaian.                                                 |
| **Sistem / Middleware**              | Cek status user sebelum akses fitur                            | Must have     | `Active` tanpa `Verified` → akses terbatas; `Verified` → akses penuh sesuai peran.             |
|                                      | Notifikasi otomatis                                            | Should have   | Memberi tahu Teacher/Supervisor jika siswa upload tugas baru.                                  |
|                                      | Deadline tugas (opsional)                                      | Could have    | Menampilkan reminder, mempermudah pengingat.                                                   |

### ⚡ Catatan:

* **Must have** = fitur inti untuk MVP agar workflow pendaftaran, pengumpulan tugas, dan penilaian PKL berjalan.
* **Should have** = fitur penting, tapi MVP bisa jalan tanpa.
* **Could have** = fitur tambahan yang memperkaya UX atau validasi, tapi tidak kritis.
* **Won’t have** = tidak ada di MVP.

---

## 5. Non-Functional Requirements (NFR) – Internara MVP

| Kategori                                     | Deskripsi                                                                                                                                                                                                                                                                              |
| -------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Performance / Kecepatan Sistem**           | Aplikasi mampu menangani minimal **500 concurrent users** tanpa penurunan kinerja. Upload Laporan PKL & PPT maksimal **5 MB/file** dengan waktu proses < 5 detik.                                                                                                                      |
| **Reliability / Keandalan**                  | Sistem tersedia **99% uptime** per bulan. Fitur upload & penilaian harus aman dari kehilangan data. Backup otomatis setiap **24 jam**.                                                                                                                                                 |
| **Scalability / Skalabilitas**               | Sistem mendukung pertumbuhan jumlah siswa, teacher, dan supervisor hingga **5x lipat** jumlah awal tanpa perubahan arsitektur utama.                                                                                                                                                   |
| **Security / Keamanan**                      | - Login menggunakan autentikasi email & password. <br> - Password tersimpan dalam bentuk **hash aman** (bcrypt/argon2). <br> - Semua endpoint API dan dashboard menggunakan HTTPS. <br> - Role-based access control untuk membatasi akses fitur (Admin, Teacher, Supervisor, Student). |
| **Usability / Kemudahan Penggunaan**         | - Dashboard user-friendly untuk masing-masing peran. <br> - Form registrasi & penugasan mudah diisi. <br> - Notifikasi dan reminder jelas untuk tugas yang harus dilakukan.                                                                                                            |
| **Maintainability / Kemudahan Pemeliharaan** | Kode modular dan terdokumentasi. Memudahkan update fitur, bug fix, dan penambahan modul baru.                                                                                                                                                                                          |
| **Compatibility / Kompatibilitas**           | Aplikasi berjalan di browser modern (Chrome, Edge, Firefox, Safari). Responsive untuk desktop dan tablet.                                                                                                                                                                              |
| **Audit & Logging**                          | Semua aktivitas penting (login, upload tugas, verifikasi, penilaian) dicatat dengan **timestamp** untuk audit.                                                                                                                                                                         |
| **Data Integrity / Integritas Data**         | Semua data tugas, nilai, dan status user konsisten. Sistem mencegah update ganda dan kehilangan data saat proses validasi.                                                                                                                                                             |
| **Availability / Ketersediaan Fitur**        | Fitur inti (pendaftaran PKL, upload Laporan & PPT, penilaian) harus selalu tersedia, bahkan saat maintenance minor di modul lain.                                                                                                                                                      |
| **Notification / Alert**                     | Sistem memberikan notifikasi otomatis untuk: <br> - Upload tugas baru. <br> - Tugas perlu review/revisi. <br> - Status penilaian terkunci.                                                                                                                                             |
| **Reporting / Laporan**                      | Admin, Teacher, dan Supervisor dapat mengekspor data penugasan dan penilaian dalam format **PDF/Excel**.                                                                                                                                                                               |
| **Backup & Recovery**                        | Backup data otomatis setiap 24 jam, recovery data maksimal **1 jam** jika terjadi kegagalan sistem.                                                                                                                                                                                    |

---

## 6. User Flow

Selengkapnya mengenai alur kerja aplikasi dapat dibaca di [USER-FLOW.MD](user-flow.md)

---

## 7. Technical Constraints – Internara MVP

| Kategori                           | Deskripsi                                                                                                                                                                        |
| ---------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Framework / Stack**              | - Backend: **PHP 8.3 + Laravel 12** <br> - Frontend: **Blade + TailwindCSS v4** <br> - Interaktivitas: **Livewire v3 + Alpine.js** <br> - Database: **MySQL / MariaDB**          |
| **Browser Compatibility**          | Mendukung browser modern: Chrome, Edge, Firefox, Safari. Responsive untuk desktop & tablet.                                                                                      |
| **Authentication & Authorization** | - Role-based access control untuk `Admin/Owner`, `Teacher`, `Supervisor`, `Student`. <br> - Middleware untuk cek status user (`Active`, `Verified`).                             |
| **File Handling / Storage**        | - Upload **Laporan PKL & PPT** menggunakan Laravel Storage. <br> - Maksimal ukuran file: 5 MB. <br> - File tersimpan di server lokal atau cloud storage (S3) sesuai konfigurasi. |
| **Real-time Updates**              | - Notifikasi tugas baru, reminder, status review menggunakan **Livewire v3 reactivity**. <br> - Tidak memerlukan WebSocket eksternal untuk MVP.                                  |
| **Email / Notification**           | - Sistem mengirim email pemberitahuan saat: <br> 1. Upload tugas baru oleh Student. <br> 2. Tugas perlu review/revisi. <br> 3. Penilaian terkunci.                               |
| **Security Constraints**           | - HTTPS wajib. <br> - Password hash menggunakan **bcrypt/argon2id**. <br> - Proteksi CSRF dan XSS melalui Laravel & Blade. <br> - Upload file hanya PDF/DOCX/PPT/PPTX.           |
| **Performance / Limitations**      | - Sistem dirancang untuk **\~500 concurrent users**. <br> - Upload file ≤5 MB harus selesai <5 detik. <br> - Query database dioptimasi dengan indexing dan eager loading.        |
| **Backup & Recovery**              | - Backup otomatis setiap 24 jam (database + storage). <br> - Recovery data maksimal 1 jam jika terjadi kerusakan.                                                                |
| **Logging / Audit**                | - Aktivitas penting dicatat dengan timestamp: login, upload tugas, penilaian, verifikasi. <br> - Log disimpan minimal 6 bulan.                                                   |

---

## 8. Environment Requirements – Internara MVP

| Kategori                    | Deskripsi                                                                                                                              |
| --------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| **Server / Hosting**        | - OS: Linux (Ubuntu 22.04 LTS direkomendasikan). <br> - PHP 8.3 <br> - Composer ≥ 2.0 <br> - Web Server: Nginx atau Apache             |
| **Database**                | - MySQL 8+ atau MariaDB 10+. <br> - Storage minimal 10 GB untuk file & data.                                                           |
| **Dependencies**            | - Laravel 12, Livewire v3, Alpine.js v3, TailwindCSS v4 <br> - PHP extensions: mbstring, PDO, OpenSSL, tokenizer, cURL, fileinfo, json |
| **Development Environment** | - Local: Laravel Sail / Docker (opsional). <br> - Editor: VSCode / PhpStorm. <br> - Node.js ≥ 18 untuk TailwindCSS v4 build.           |
| **Network / Connectivity**  | - Internet stabil untuk akses email & optional cloud storage. <br> - HTTPS wajib untuk semua komunikasi.                               |
| **Deployment**              | - Bisa deploy di VPS/Server sendiri atau cloud (DigitalOcean, AWS, GCP). <br> - Cron job untuk backup otomatis & notifikasi Livewire.  |

