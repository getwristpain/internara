<?php

namespace App\Helpers;

use App\Helpers\Helper;
use Illuminate\Http\UploadedFile;

class Uploader extends Helper
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public static function upload(UploadedFile $file, string $path, string $fileName = '', string $storage = 'public'): string
    {
        $fileName = self::generateFileName($fileName, $file->getClientOriginalExtension());
        self::storeAs($file, $path, $fileName, $storage);
        return implode('/', [$path, $fileName]);
    }

    protected function generateFileName(string $fileName = '', string $extension = ''): string
    {
        return parent::key($fileName ?: md5(uniqid())) . '.' . $extension;
    }

    protected function storeAs(UploadedFile $file, string $path, string $fileName, string $storage = 'public')
    {
        return $file->storeAs($path, $fileName, $storage);
    }
}
