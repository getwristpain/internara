# App Design Breakdown

## User Flow

### Owner/Admin

- [ ] Instalasi (Application Setup)
  - [ ] Admin sekolah menginstal aplikasi dengan menuju ke halaman `/setup`
  - [ ] Terdapat welcome page yang berisi langkah instalasi aplikasi
  - [ ] Admin membuat akun akun pengguna yang ditandai sebagai `admin` sekaligus `owner`
  - [ ] Admin menyetel data awal sekolah
  - [ ] Admin menambahkan data jurusan sekolah
  - [ ] Admin menambahkan daftar program PKL
  - [ ] Di halaman akhir, aplikasi akan ditandai sebagai `installed`
  - [ ] Jika seluruh proses berhasil, alihkan menuju halaman `/login`
  - [ ] Tambahkan middleware untuk memudahkan identifikasi penginstalan sistem dan menyaring akses pengguna
- [ ] Otentikasi dan Otorisasi:
  - [ ] Pengguna dengan peran `admin` akan dialihkan menuju `/admin` saat masuk
  - [ ] Tidak ada registrasi akun secara eksternal untuk peran `admin`
  - [ ] Admin panel hanya dapat diakses oleh pengguna dengan peran `admin`
  - [ ] Akun `owner` sama sekali tidak dapat dihapus dan `owner` dapat mengakses seluruh fitur aplikasi
  - [ ] Tambahkan middleware untuk mengotentikasi pengguna
- [ ] Manajemen Pengguna:
  - [ ] Admin dapat menambahkan akun admin lain, namun hanya akan ditandai sebagai `admin`
  - [ ] Pengguna yang mendapat peran `admin` tidak dapat menghapus akun admin lain dan dirinya sendiri
  - [ ] Admin dapat menambahkan daftar siswa, guru dan supervisor, serta membuat akun untuknya
  - [ ] Akun yang pertama kali dibuat akan diberikan status `pending-activation`, kecuali akun admin yang akan ditandai sebagai `protected`
  - [ ] Peran dan status `admin` tidak dapat diubah (hanya dapat mengubah email, password dan profilnya saja), kecuali oleh `owner`
  - [ ] Hanya `owner` yang dapat menghapus dan mengedit akun admin secara penuh
  - [ ] `Owner` dapat melihat dan mengatur seluruh daftar penggunanya
  - [ ] `Admin` dapat melihat daftar admin (read-only), juga dapat melihat dan mengatur seluruh daftar pengguna non-admin
