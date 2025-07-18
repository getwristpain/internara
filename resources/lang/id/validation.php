<?php

declare(strict_types=1);

return [
    'accepted'               => ':Attribute harus diterima.',
    'accepted_if'            => ':Attribute harus diterima ketika :other berisi :value.',
    'active_url'             => ':Attribute bukan URL yang valid.',
    'after'                  => ':Attribute harus berisi tanggal setelah :date.',
    'after_or_equal'         => ':Attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                  => ':Attribute hanya boleh berisi huruf.',
    'alpha_dash'             => ':Attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'              => ':Attribute hanya boleh berisi huruf dan angka.',
    'any_of'                 => 'Bidang :attribute tidak valid.',
    'array'                  => ':Attribute harus berisi sebuah array.',
    'ascii'                  => ':Attribute hanya boleh berisi karakter dan simbol alfanumerik single-byte.',
    'before'                 => ':Attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'        => ':Attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'                => [
        'array'   => ':Attribute harus memiliki :min sampai :max anggota.',
        'file'    => ':Attribute harus berukuran antara :min sampai :max kilobita.',
        'numeric' => ':Attribute harus bernilai antara :min sampai :max.',
        'string'  => ':Attribute harus berisi antara :min sampai :max karakter.',
    ],
    'boolean'                => ':Attribute harus bernilai true atau false',
    'can'                    => 'Bidang :attribute berisi nilai yang tidak sah.',
    'confirmed'              => 'Konfirmasi :attribute tidak cocok.',
    'contains'               => 'Bidang :attribute tidak memiliki nilai yang diperlukan.',
    'current_password'       => 'Kata sandi salah.',
    'date'                   => ':Attribute bukan tanggal yang valid.',
    'date_equals'            => ':Attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'            => ':Attribute tidak cocok dengan format :format.',
    'decimal'                => ':Attribute harus memiliki :decimal tempat desimal.',
    'declined'               => ':Attribute ini harus ditolak.',
    'declined_if'            => ':Attribute ini harus ditolak ketika :other bernilai :value.',
    'different'              => ':Attribute dan :other harus berbeda.',
    'digits'                 => ':Attribute harus terdiri dari :digits angka.',
    'digits_between'         => ':Attribute harus terdiri dari :min sampai :max angka.',
    'dimensions'             => ':Attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'               => ':Attribute memiliki nilai yang duplikat.',
    'doesnt_end_with'        => ':Attribute tidak boleh diakhiri dengan salah satu dari berikut ini: :values.',
    'doesnt_start_with'      => ':Attribute tidak boleh dimulai dengan salah satu dari berikut ini: :values.',
    'email'                  => ':Attribute harus berupa alamat surel yang valid.',
    'ends_with'              => ':Attribute harus diakhiri salah satu dari berikut: :values',
    'enum'                   => ':Attribute yang dipilih tidak valid.',
    'exists'                 => ':Attribute yang dipilih tidak valid.',
    'extensions'             => 'Bidang :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file'                   => ':Attribute harus berupa sebuah berkas.',
    'filled'                 => ':Attribute harus memiliki nilai.',
    'gt'                     => [
        'array'   => ':Attribute harus memiliki lebih dari :value anggota.',
        'file'    => ':Attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => ':Attribute harus bernilai lebih besar dari :value.',
        'string'  => ':Attribute harus berisi lebih besar dari :value karakter.',
    ],
    'gte'                    => [
        'array'   => ':Attribute harus terdiri dari :value anggota atau lebih.',
        'file'    => ':Attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':Attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string'  => ':Attribute harus berisi lebih besar dari atau sama dengan :value karakter.',
    ],
    'hex_color'              => 'Bidang :attribute harus berupa warna heksadesimal yang valid.',
    'image'                  => ':Attribute harus berupa gambar.',
    'in'                     => ':Attribute yang dipilih tidak valid.',
    'in_array'               => ':Attribute tidak ada di dalam :other.',
    'in_array_keys'          => ':attribute bidang harus berisi setidaknya satu dari tombol berikut: :values.',
    'integer'                => ':Attribute harus berupa bilangan bulat.',
    'ip'                     => ':Attribute harus berupa alamat IP yang valid.',
    'ipv4'                   => ':Attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                   => ':Attribute harus berupa alamat IPv6 yang valid.',
    'json'                   => ':Attribute harus berupa JSON string yang valid.',
    'list'                   => 'Bidang :attribute harus berupa daftar.',
    'lowercase'              => ':Attribute harus berupa huruf kecil.',
    'lt'                     => [
        'array'   => ':Attribute harus memiliki kurang dari :value anggota.',
        'file'    => ':Attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => ':Attribute harus bernilai kurang dari :value.',
        'string'  => ':Attribute harus berisi kurang dari :value karakter.',
    ],
    'lte'                    => [
        'array'   => ':Attribute harus tidak lebih dari :value anggota.',
        'file'    => ':Attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'numeric' => ':Attribute harus bernilai kurang dari atau sama dengan :value.',
        'string'  => ':Attribute harus berisi kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address'            => ':Attribute harus berupa alamat MAC yang valid.',
    'max'                    => [
        'array'   => ':Attribute maksimal terdiri dari :max anggota.',
        'file'    => ':Attribute maksimal berukuran :max kilobita.',
        'numeric' => ':Attribute maksimal bernilai :max.',
        'string'  => ':Attribute maksimal berisi :max karakter.',
    ],
    'max_digits'             => ':Attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes'                  => ':Attribute harus berupa berkas berjenis: :values.',
    'mimetypes'              => ':Attribute harus berupa berkas berjenis: :values.',
    'min'                    => [
        'array'   => ':Attribute minimal terdiri dari :min anggota.',
        'file'    => ':Attribute minimal berukuran :min kilobita.',
        'numeric' => ':Attribute minimal bernilai :min.',
        'string'  => ':Attribute minimal berisi :min karakter.',
    ],
    'min_digits'             => ':Attribute tidak boleh memiliki kurang dari :min digit.',
    'missing'                => 'Bidang :attribute harus hilang.',
    'missing_if'             => 'Bidang :attribute harus hilang ketika :other adalah :value.',
    'missing_unless'         => 'Bidang :attribute harus hilang kecuali :other adalah :value.',
    'missing_with'           => 'Kolom :attribute harus hilang saat ada :values.',
    'missing_with_all'       => 'Kolom :attribute harus hilang jika ada :values.',
    'multiple_of'            => ':Attribute harus merupakan kelipatan dari :value',
    'not_in'                 => ':Attribute yang dipilih tidak valid.',
    'not_regex'              => 'Format :attribute tidak valid.',
    'numeric'                => ':Attribute harus berupa angka.',
    'password'               => [
        'letters'       => ':Attribute ini harus memiliki setidaknya satu karakter.',
        'mixed'         => ':Attribute ini harus memiliki setidaknya satu huruf kapital dan satu huruf kecil.',
        'numbers'       => ':Attribute ini harus memiliki setidaknya satu angka.',
        'symbols'       => ':Attribute ini harus memiliki setidaknya satu simbol.',
        'uncompromised' => ':Attribute ini telah muncul di kebocoran data. Silahkan memilih :attribute yang berbeda.',
    ],
    'present'                => ':Attribute wajib ada.',
    'present_if'             => 'Bidang :attribute harus ada ketika :other adalah :value.',
    'present_unless'         => 'Bidang :attribute harus ada kecuali :other adalah :value.',
    'present_with'           => 'Bidang :attribute harus ada bila ada :values.',
    'present_with_all'       => 'Bidang :attribute harus ada ketika ada :values.',
    'prohibited'             => ':Attribute tidak boleh ada.',
    'prohibited_if'          => ':Attribute tidak boleh ada bila :other adalah :value.',
    'prohibited_if_accepted' => ':attribute bidang dilarang ketika :other diterima.',
    'prohibited_if_declined' => ':attribute bidang dilarang ketika :other ditolak.',
    'prohibited_unless'      => ':Attribute tidak boleh ada kecuali :other memiliki nilai :values.',
    'prohibits'              => ':Attribute melarang isian :other untuk ditampilkan.',
    'regex'                  => 'Format :attribute tidak valid.',
    'required'               => ':Attribute wajib diisi.',
    'required_array_keys'    => ':Attribute wajib berisi entri untuk: :values.',
    'required_if'            => ':Attribute wajib diisi bila :other adalah :value.',
    'required_if_accepted'   => ':Attribute wajib diisi bila :other sesuai.',
    'required_if_declined'   => 'Bidang :attribute wajib diisi bila :other ditolak.',
    'required_unless'        => ':Attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'          => ':Attribute wajib diisi bila terdapat :values.',
    'required_with_all'      => ':Attribute wajib diisi bila terdapat :values.',
    'required_without'       => ':Attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all'   => ':Attribute wajib diisi bila sama sekali tidak terdapat :values.',
    'same'                   => ':Attribute dan :other harus sama.',
    'size'                   => [
        'array'   => ':Attribute harus mengandung :size anggota.',
        'file'    => ':Attribute harus berukuran :size kilobyte.',
        'numeric' => ':Attribute harus berukuran :size.',
        'string'  => ':Attribute harus berukuran :size karakter.',
    ],
    'starts_with'            => ':Attribute harus diawali salah satu dari berikut: :values',
    'string'                 => ':Attribute harus berupa string.',
    'timezone'               => ':Attribute harus berisi zona waktu yang valid.',
    'ulid'                   => ':Attribute harus merupakan ULID yang valid.',
    'unique'                 => ':Attribute sudah ada sebelumnya.',
    'uploaded'               => ':Attribute gagal diunggah.',
    'uppercase'              => ':Attribute harus berupa huruf kapital.',
    'url'                    => 'Format :attribute tidak valid.',
    'uuid'                   => ':Attribute harus merupakan UUID yang valid.',
    'attributes'             => [
        'address'                         => 'alamat',
        'admin.email'                     => 'email admin',
        'admin.name'                      => 'nama admin',
        'admin.password'                  => 'kata sandi admin',
        'affiliate_url'                   => 'URL afiliasi',
        'age'                             => 'usia',
        'amount'                          => 'jumlah',
        'announcement'                    => 'pengumuman',
        'area'                            => 'daerah',
        'audience_prize'                  => 'hadiah penonton',
        'audience_winner'                 => 'audience winner',
        'available'                       => 'tersedia',
        'birthday'                        => 'hari ulang tahun',
        'body'                            => 'badan',
        'city'                            => 'kota',
        'classroom.code'                  => 'kode kelas',
        'classroom.description'           => 'deskripsi kelas',
        'classroom.name'                  => 'nama kelas',
        'code'                            => 'code',
        'company'                         => 'company',
        'compilation'                     => 'kompilasi',
        'concept'                         => 'konsep',
        'conditions'                      => 'kondisi',
        'content'                         => 'konten',
        'contest'                         => 'contest',
        'country'                         => 'negara',
        'cover'                           => 'menutupi',
        'created_at'                      => 'dibuat di',
        'creator'                         => 'pencipta',
        'currency'                        => 'mata uang',
        'current_password'                => 'kata sandi saat ini',
        'customer'                        => 'pelanggan',
        'data.address'                    => 'alamat',
        'data.admin.email'                => 'email admin',
        'data.admin.name'                 => 'nama admin',
        'data.admin.password'             => 'kata sandi admin',
        'data.classroom.code'             => 'kode kelas',
        'data.classroom.description'      => 'deskripsi kelas',
        'data.classroom.name'             => 'nama kelas',
        'data.code'                       => 'code',
        'data.department.code'            => 'kode jurusan',
        'data.department.description'     => 'deskripsi jurusan',
        'data.department.name'            => 'nama jurusan',
        'data.district_id'                => 'kecamatan',
        'data.email'                      => 'alamat email',
        'data.fax'                        => 'nomor fax',
        'data.logo'                       => 'logo',
        'data.name'                       => 'nama',
        'data.new_classroom.code'         => 'kode kelas',
        'data.new_classroom.description'  => 'deskripsi kelas',
        'data.new_classroom.name'         => 'nama kelas',
        'data.new_department.code'        => 'kode jurusan',
        'data.new_department.description' => 'deskripsi jurusan',
        'data.new_department.name'        => 'nama jurusan',
        'data.owner.email'                => 'email pengguna',
        'data.owner.name'                 => 'nama pengguna',
        'data.owner.password'             => 'kata sandi pengguna',
        'data.password'                   => 'kata sandi',
        'data.phone'                      => 'nomor telepon',
        'data.postal_code'                => 'kode pos',
        'data.province_id'                => 'provinsi',
        'data.regency_id'                 => 'kabupaten/kota',
        'data.school.address'             => 'alamat sekolah',
        'data.school.email'               => 'email sekolah',
        'data.school.fax'                 => 'fax sekolah',
        'data.school.logo_file'           => 'berkas logo sekolah',
        'data.school.logo_path'           => 'logo sekolah',
        'data.school.name'                => 'nama sekolah',
        'data.school.phone'               => 'telepon sekolah',
        'data.school.principal_name'      => 'nama kepala sekolah',
        'data.school.website'             => 'website sekolah',
        'data.user.email'                 => 'email pengguna',
        'data.user.name'                  => 'nama pengguna',
        'data.user.password'              => 'kata sandi pengguna',
        'data.village_id'                 => 'desa/kelurahan',
        'data.website'                    => 'situs web',
        'date'                            => 'tanggal',
        'date_of_birth'                   => 'tanggal lahir',
        'dates'                           => 'tanggal',
        'day'                             => 'hari',
        'deleted_at'                      => 'dihapus pada',
        'department.code'                 => 'kode jurusan',
        'department.description'          => 'deskripsi jurusan',
        'department.name'                 => 'nama jurusan',
        'description'                     => 'deskripsi',
        'display_type'                    => 'tipe tampilan',
        'district'                        => 'daerah',
        'district_id'                     => 'kecamatan',
        'duration'                        => 'durasi',
        'email'                           => 'surel',
        'excerpt'                         => 'kutipan',
        'fax'                             => 'nomor fax',
        'filter'                          => 'Saring',
        'finished_at'                     => 'selesai pada',
        'first_name'                      => 'nama depan',
        'form.address'                    => 'alamat',
        'form.admin.email'                => 'email admin',
        'form.admin.name'                 => 'nama admin',
        'form.admin.password'             => 'kata sandi admin',
        'form.classroom.code'             => 'kode kelas',
        'form.classroom.description'      => 'deskripsi kelas',
        'form.classroom.name'             => 'nama kelas',
        'form.code'                       => 'code',
        'form.department.code'            => 'kode jurusan',
        'form.department.description'     => 'deskripsi jurusan',
        'form.department.name'            => 'nama jurusan',
        'form.district_id'                => 'kecamatan',
        'form.email'                      => 'alamat email',
        'form.fax'                        => 'nomor fax',
        'form.logo'                       => 'logo',
        'form.name'                       => 'nama',
        'form.new_classroom.code'         => 'kode kelas',
        'form.new_classroom.description'  => 'deskripsi kelas',
        'form.new_classroom.name'         => 'nama kelas',
        'form.new_department.code'        => 'kode jurusan',
        'form.new_department.description' => 'deskripsi jurusan',
        'form.new_department.name'        => 'nama jurusan',
        'form.owner.email'                => 'email pengguna',
        'form.owner.name'                 => 'nama pengguna',
        'form.owner.password'             => 'kata sandi pengguna',
        'form.password'                   => 'kata sandi',
        'form.phone'                      => 'nomor telepon',
        'form.postal_code'                => 'kode pos',
        'form.province_id'                => 'provinsi',
        'form.regency_id'                 => 'kabupaten/kota',
        'form.school.address'             => 'alamat sekolah',
        'form.school.email'               => 'email sekolah',
        'form.school.fax'                 => 'fax sekolah',
        'form.school.logo_file'           => 'berkas logo sekolah',
        'form.school.logo_path'           => 'logo sekolah',
        'form.school.name'                => 'nama sekolah',
        'form.school.phone'               => 'telepon sekolah',
        'form.school.principal_name'      => 'nama kepala sekolah',
        'form.school.website'             => 'website sekolah',
        'form.user.email'                 => 'email pengguna',
        'form.user.name'                  => 'nama pengguna',
        'form.user.password'              => 'kata sandi pengguna',
        'form.village_id'                 => 'desa/kelurahan',
        'form.website'                    => 'situs web',
        'gender'                          => 'jenis kelamin',
        'grand_prize'                     => 'hadiah utama',
        'group'                           => 'kelompok',
        'hour'                            => 'jam',
        'image'                           => 'gambar',
        'image_desktop'                   => 'gambar desktop',
        'image_main'                      => 'gambar utama',
        'image_mobile'                    => 'gambar seluler',
        'images'                          => 'gambar-gambar',
        'is_audience_winner'              => 'adalah pemenang penonton',
        'is_hidden'                       => 'tersembunyi',
        'is_subscribed'                   => 'berlangganan',
        'is_visible'                      => 'terlihat',
        'is_winner'                       => 'adalah pemenang',
        'items'                           => 'item',
        'key'                             => 'kunci',
        'last_name'                       => 'nama belakang',
        'lesson'                          => 'pelajaran',
        'line_address_1'                  => 'alamat baris 1',
        'line_address_2'                  => 'alamat baris 2',
        'login'                           => 'Gabung',
        'logo'                            => 'logo',
        'message'                         => 'pesan',
        'middle_name'                     => 'nama tengah',
        'minute'                          => 'menit',
        'mobile'                          => 'seluler',
        'month'                           => 'bulan',
        'name'                            => 'nama',
        'national_code'                   => 'kode nasional',
        'new_classroom.code'              => 'kode kelas',
        'new_classroom.description'       => 'deskripsi kelas',
        'new_classroom.name'              => 'nama kelas',
        'new_department.code'             => 'kode jurusan',
        'new_department.description'      => 'deskripsi jurusan',
        'new_department.name'             => 'nama jurusan',
        'number'                          => 'nomor',
        'owner.email'                     => 'email pengguna',
        'owner.name'                      => 'nama pengguna',
        'owner.password'                  => 'kata sandi pengguna',
        'password'                        => 'kata sandi',
        'password_confirmation'           => 'konfirmasi kata sandi',
        'phone'                           => 'telepon',
        'photo'                           => 'foto',
        'portfolio'                       => 'portofolio',
        'postal_code'                     => 'kode Pos',
        'preview'                         => 'pratinjau',
        'price'                           => 'harga',
        'product_id'                      => 'ID Produk',
        'product_uid'                     => 'UID produk',
        'product_uuid'                    => 'UUID produk',
        'promo_code'                      => 'Kode promosi',
        'province'                        => 'propinsi',
        'province_id'                     => 'provinsi',
        'quantity'                        => 'kuantitas',
        'reason'                          => 'alasan',
        'recaptcha_response_field'        => 'bidang respons recaptcha',
        'referee'                         => 'wasit',
        'referees'                        => 'wasit',
        'regency_id'                      => 'kabupaten/kota',
        'reject_reason'                   => 'menolak alasan',
        'remember'                        => 'ingat',
        'restored_at'                     => 'dipulihkan pada',
        'result_text_under_image'         => 'teks hasil di bawah gambar',
        'role'                            => 'peran',
        'rule'                            => 'aturan',
        'rules'                           => 'aturan',
        'school.address'                  => 'alamat sekolah',
        'school.email'                    => 'email sekolah',
        'school.fax'                      => 'fax sekolah',
        'school.logo_file'                => 'berkas logo sekolah',
        'school.logo_path'                => 'logo sekolah',
        'school.name'                     => 'nama sekolah',
        'school.phone'                    => 'telepon sekolah',
        'school.principal_name'           => 'nama kepala sekolah',
        'school.website'                  => 'website sekolah',
        'second'                          => 'detik',
        'sex'                             => 'jenis kelamin',
        'shipment'                        => 'pengiriman',
        'short_text'                      => 'teks pendek',
        'size'                            => 'ukuran',
        'skills'                          => 'keterampilan',
        'slug'                            => 'siput',
        'specialization'                  => 'spesialisasi',
        'started_at'                      => 'dimulai pada',
        'state'                           => 'negara',
        'status'                          => 'status',
        'street'                          => 'jalan',
        'student'                         => 'siswa',
        'subject'                         => 'subyek',
        'tag'                             => 'menandai',
        'tags'                            => 'tag',
        'teacher'                         => 'guru',
        'terms'                           => 'ketentuan',
        'test_description'                => 'deskripsi tes',
        'test_locale'                     => 'uji lokal',
        'test_name'                       => 'nama tes',
        'text'                            => 'teks',
        'time'                            => 'waktu',
        'title'                           => 'judul',
        'type'                            => 'jenis',
        'updated_at'                      => 'diperbarui pada',
        'user.email'                      => 'email pengguna',
        'user.name'                       => 'nama pengguna',
        'user.password'                   => 'kata sandi pengguna',
        'username'                        => 'nama pengguna',
        'value'                           => 'nilai',
        'village_id'                      => 'desa/kelurahan',
        'website'                         => 'situs web',
        'winner'                          => 'winner',
        'work'                            => 'work',
        'year'                            => 'tahun',
    ],
];
