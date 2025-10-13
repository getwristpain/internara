<?php

$appName = env('APP_NAME', 'Internara');
$description = 'Sistem Informasi Manajemen PKL';

return [
    'brand_name' => $appName,
    'brand_description' => $description,
    'brand_signature' => $appName . ' - ' . $description,
    'brand_logo' => null,
    'brand_logo_dark' => null,
];
