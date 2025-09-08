# Requirement Specification

---

## Latar Belakang

Pelaksanaan Program Praktik Kerja Lapangan (PKL) di sekolah sering menghadapi kendala dalam proses pendaftaran peserta, pengumpulan tugas, dan penilaian siswa. Proses pendaftaran masih dilakukan secara manual, pengumpulan laporan dan dokumen PKL tersebar dalam berbagai format, serta evaluasi siswa dilakukan berdasarkan laporan periodik yang tidak selalu tepat waktu. Hal ini menyebabkan beban administrasi yang tinggi bagi guru pembimbing, keterlambatan umpan balik untuk siswa, dan koordinasi yang kurang efektif dengan supervisor perusahaan. Selain itu, siswa sering kesulitan mengakses informasi penting mengenai PKL, seperti jadwal, tugas, dan hasil evaluasi, sehingga menghambat kelancaran proses belajar praktik.

Untuk mengatasi permasalahan tersebut, dibutuhkan sistem manajemen PKL yang terintegrasi, yang memungkinkan pendaftaran peserta secara mudah, pengumpulan tugas dan laporan secara digital, serta penilaian siswa yang dapat dilakukan secara real-time. Dengan sistem ini, administrasi PKL menjadi lebih efisien, guru pembimbing dapat fokus memberikan bimbingan dan evaluasi yang tepat, siswa menerima umpan balik lebih cepat, dan koordinasi antara sekolah dan mitra industri berjalan lebih optimal. Sistem manajemen PKL yang efektif diharapkan meningkatkan kualitas pelaksanaan PKL serta kesiapan siswa dalam menghadapi dunia kerja.

---

## Tujuan

Tujuan utama pengembangan sistem Internara adalah untuk meningkatkan efisiensi dan efektivitas pengelolaan Program Praktik Kerja Lapangan (PKL) di tingkat sekolah dengan menyediakan platform terintegrasi untuk:

* Pendaftaran Peserta PKL – Memfasilitasi proses registrasi siswa secara digital, cepat, dan akurat.
* Pengumpulan Tugas dan Laporan PKL – Mengotomatisasi pengumpulan dokumen dan laporan, sehingga guru dan siswa tidak lagi terbebani oleh proses manual.
* Penilaian Siswa PKL – Memberikan mekanisme evaluasi yang real-time dan transparan, memungkinkan guru pembimbing dan supervisor memberikan umpan balik tepat waktu.

---

## Manfaat

Penerapan sistem Internara diharapkan memberikan manfaat sebagai berikut:

* Efisiensi Administrasi – Mengurangi waktu dan tenaga yang dibutuhkan untuk pendaftaran peserta dan pengumpulan tugas PKL.
* Kualitas Pembimbingan Lebih Baik – Guru pembimbing dapat fokus memberikan evaluasi dan bimbingan karena beban administrasi berkurang.
* Transparansi dan Ketepatan Informasi – Siswa menerima informasi terkait pendaftaran, tugas, dan hasil penilaian secara jelas dan tepat waktu.
* Evaluasi Siswa Lebih Cepat dan Akurat – Umpan balik dari guru dan supervisor dapat diberikan secara tepat waktu, mendukung pengembangan keterampilan siswa secara optimal.

---

## Functional Requirements

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

---

### ⚡ Catatan:

* **Must have** = fitur inti untuk MVP agar workflow pendaftaran, pengumpulan tugas, dan penilaian PKL berjalan.
* **Should have** = fitur penting, tapi MVP bisa jalan tanpa.
* **Could have** = fitur tambahan yang memperkaya UX atau validasi, tapi tidak kritis.
* **Won’t have** = tidak ada di MVP.

---
