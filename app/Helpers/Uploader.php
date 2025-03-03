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

    public static function getPublicUrl($url): string
    {
        return asset('storage/' . $url);
    }

    public static function upload(UploadedFile $file, string $path, string $fileName = '', string $storage = 'public'): string
    {
        try {
            $fileName = self::generateFileName($fileName, $file->getClientOriginalExtension());
            self::storeAs($file, $path, $fileName, $storage);
            return implode('/', [$path, $fileName]);
        } catch (\Throwable $th) {
            static::debug('error', 'Failed to upload file', $th);
            throw $th;
        }
    }

    protected static function generateFileName(string $fileName = '', string $extension = ''): string
    {
        return parent::key($fileName ?: md5(uniqid())) . '.' . $extension;
    }

    protected static function storeAs(UploadedFile $file, string $path, string $fileName, string $storage = 'public')
    {
        return $file->storeAs($path, $fileName, $storage);
    }
}
