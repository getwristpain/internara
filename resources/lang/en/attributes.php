<?php

$attributes = [
    'address' => 'address',
    'admin' => [
        'name' => 'admin name',
        'email' => 'admin email',
        'password' => 'admin password',
    ],
    'classroom' => [
        'code' => 'class code',
        'name' => 'class name',
        'description' => 'class description',
    ],
    'code' => 'code',
    'department' => [
        'code' => 'department code',
        'name' => 'department name',
        'description' => 'department description',
    ],
    'district_id' => 'district',
    'email' => 'email address',
    'fax' => 'fax number',
    'logo' => 'logo',
    'name' => 'name',
    'new_classroom' => [
        'code' => 'class code',
        'name' => 'class name',
        'description' => 'class description',
    ],
    'new_department' => [
        'code' => 'department code',
        'name' => 'department name',
        'description' => 'department description',
    ],
    'owner' => [
        'name' => 'user name',
        'email' => 'user email',
        'password' => 'user password',
    ],
    'password' => 'password',
    'phone' => 'phone number',
    'postal_code' => 'postal code',
    'province_id' => 'province',
    'regency_id' => 'regency/municipality',
    'school' => [
        'name' => 'school name',
        'logo_path' => 'school logo',
        'logo_file' => 'school logo file',
        'address' => 'school address',
        'email' => 'school email',
        'phone' => 'school phone',
        'fax' => 'school fax',
        'website' => 'school website',
        'principal_name' => 'principal name',
    ],
    'user' => [
        'name' => 'user name',
        'email' => 'user email',
        'password' => 'user password',
    ],
    'village_id' => 'village/sub-district',
    'website' => 'website',
];

return array_merge(
    $attributes,
    [
        'data' => $attributes,
        'form' => $attributes,
    ]
);
