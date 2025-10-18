<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Exceptions\AppException;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media
{
    /**
     * Uploads the file and associates it with the given model using Spatie Media Library.
     *
     * @param UploadedFile|null $file The uploaded file instance.
     * @param HasMedia $model The Eloquent model implementing HasMedia.
     * @param string $collectionName The name of the media collection (default is 'default').
     * @param string $label The custom label to be included in the generated file name (default is 'document').
     * @return SpatieMedia
     * @throws AppException If the file is not found or the upload fails.
     */
    public static function upload(?UploadedFile $file, HasMedia $model, string $collectionName = 'default', string $label = 'document'): SpatieMedia
    {
        if (!$file) {
            throw new AppException(
                'Berkas tidak ditemukan.',
                'ERROR: File not found.',
            );
        }

        // Clean the label for use in file names
        $cleanLabel = Str::slug(strtolower($label));

        // Generate the new file name based on the required format
        $timestamp = now()->timestamp;
        $extension = $file->getClientOriginalExtension();
        $uniqueId = Str::random(8);

        $internalName = Str::slug(implode('_', [$cleanLabel, $timestamp, $uniqueId]));
        $newFileName = "{$internalName}.{$extension}";

        try {
            $media = $model->addMedia($file->getRealPath())
                ->usingFileName($newFileName)
                ->usingName($internalName)
                ->toMediaCollection($collectionName);

            return $media;
        } catch (\Exception $e) {
            throw new AppException(
                'Gagal mengunggah berkas.',
                'Failed to upload file: ' . $e->getMessage(),
                previous: $e
            );
        }
    }
}
