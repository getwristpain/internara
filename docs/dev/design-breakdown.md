# App Design Breakdown

## User Flow

### Owner/Admin

- [#] Instalasi (Application Setup)
  - [v] Admin sekolah menginstal aplikasi dengan menuju ke halaman `/setup`
  - [v] Terdapat welcome page yang berisi langkah instalasi aplikasi
  - [v] Admin membuat akun akun pengguna yang ditandai sebagai `admin` sekaligus `owner`
  - [v] Admin menyetel data awal sekolah
  - [v] Admin menambahkan data jurusan sekolah
  - [v] Admin menambahkan daftar program PKL
  - [v] Di halaman akhir, aplikasi akan ditandai sebagai `installed`
  - [v] Jika seluruh proses berhasil, alihkan menuju halaman `/login`
  - [v] Tambahkan middleware untuk memudahkan identifikasi penginstalan sistem dan menyaring akses pengguna
- [#] Login:
  - [v] Admin masuk menggunakan email dan password yang telah dibuat
  - [v] Pengguna dengan peran `admin` akan dialihkan menuju `/admin` saat masuk
  - [v] Admin panel hanya dapat diakses oleh pengguna dengan peran `admin` dan `owner`
  - [v] Tambahkan middleware untuk mengotentikasi pengguna
  - [v] Tidak ada registrasi akun secara eksternal untuk peran `admin`
- [ ] Manajemen Pengguna:
  - [ ] Hanya `owner` yang diizinkan untuk mengakses menu manajemen pengguna
  - [ ] Hanya `owner` yang dapat menghapus dan mengedit pengguna secara penuh
  - [ ] Pengguna dengan peran `owner` tidak dapat diedit maupun dihapus oleh siapapun
  - [ ] Akun yang pertama kali dibuat akan diberikan status `pending-activation`, kecuali akun `admin` yang harus ditandai sebagai `protected`
  - [v] Tambahkan policy untuk mencegah akun `owner` terhapus
