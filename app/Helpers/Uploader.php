<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class Uploader extends Helper
{
    public static function getPublicUrl($url): string
    {
        return asset("storage/{$url}");
    }

    public static function upload(UploadedFile $file, string $path, string $fileName = '', string $storage = 'public'): string
    {
        try {
            $fileName = self::generateFileName($fileName, $file->getClientOriginalExtension());
            $path = "uploads/{$path}";

            self::storeAs($file, $path, $fileName, $storage);

            return implode('/', ['storage', $path, $fileName]);
        } catch (\Throwable $th) {
            parent::handleError('error', 'Failed to upload file', $th);
            throw $th;
        }
    }

    protected static function generateFileName(string $fileName = '', string $extension = ''): string
    {
        return parent::key($fileName ?: md5(uniqid())).'.'.$extension;
    }

    protected static function storeAs(UploadedFile $file, string $path, string $fileName, string $storage = 'public')
    {
        return $file->storeAs($path, $fileName, $storage);
    }
}
