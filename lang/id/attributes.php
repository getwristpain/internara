<?php

$attributes = [
    'address' => 'alamat',
    'admin' => [
        'name' => 'nama admin',
        'email' => 'email admin',
        'password' => 'kata sandi admin',
    ],
    'code' => 'code',
    'department' => [
        'code' => 'kode jurusan',
        'name' => 'nama jurusan',
    ],
    'district_id' => 'kecamatan',
    'email' => 'alamat email',
    'fax' => 'nomor fax',
    'logo' => 'logo',
    'name' => 'nama',
    'password' => 'kata sandi',
    'phone' => 'nomor telepon',
    'postal_code' => 'kode pos',
    'province_id' => 'provinsi',
    'regency_id' => 'kabupaten/kota',
    'school' => [
        'address' => 'alamat sekolah',
        'email' => 'email sekolah',
        'fax' => 'fax sekolah',
        'logo' => 'logo sekolah',
        'name' => 'nama sekolah',
        'phone' => 'telepon sekolah',
        'principal_name' => 'kepala sekolah',
        'website' => 'situs web sekolah',
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
