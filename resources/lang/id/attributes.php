<?php

$attributes = [
    'address' => 'alamat',
    'admin' => [
        'name' => 'nama admin',
        'email' => 'email admin',
        'password' => 'kata sandi admin',
    ],
    'classroom' => [
        'code' => 'kode kelas',
        'name' => 'nama kelas',
        'description' => 'deskripsi kelas',
    ],
    'code' => 'code',
    'department' => [
        'code' => 'kode jurusan',
        'name' => 'nama jurusan',
        'description' => 'deskripsi jurusan',
    ],
    'district_id' => 'kecamatan',
    'email' => 'alamat email',
    'fax' => 'nomor fax',
    'logo' => 'logo',
    'name' => 'nama',
    'new_classroom' => [
        'code' => 'kode kelas',
        'name' => 'nama kelas',
        'description' => 'deskripsi kelas',
    ],
    'new_department' => [
        'code' => 'kode jurusan',
        'name' => 'nama jurusan',
        'description' => 'deskripsi jurusan',
    ],
    'owner' => [
        'name' => 'nama pengguna',
        'email' => 'email pengguna',
        'password' => 'kata sandi pengguna',
    ],
    'password' => 'kata sandi',
    'phone' => 'nomor telepon',
    'postal_code' => 'kode pos',
    'province_id' => 'provinsi',
    'regency_id' => 'kabupaten/kota',
    'school' => [
        'name' => 'nama sekolah',
        'logo_path' => 'logo sekolah',
        'logo_file' => 'berkas logo sekolah',
        'address' => 'alamat sekolah',
        'email' => 'email sekolah',
        'phone' => 'telepon sekolah',
        'fax' => 'fax sekolah',
        'website' => 'website sekolah',
        'principal_name' => 'nama kepala sekolah',
    ],
    'user' => [
        'name' => 'nama pengguna',
        'email' => 'email pengguna',
        'password' => 'kata sandi pengguna',
    ],
    'village_id' => 'desa/kelurahan',
    'website' => 'situs web',
];

return array_merge(
    $attributes,
    [
        'data' => $attributes,
        'form' => $attributes,
    ]
);
