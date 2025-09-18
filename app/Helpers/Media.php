<?php

namespace App\Helpers;

use App\Helpers\Generator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Throwable;

class Media
{
    /**
     * @var bool Indicates whether the upload was successful.
     */
    protected bool $isSuccessful = false;

    /**
     * @var string|null An error message if the upload failed.
     */
    protected ?string $errorMessage = null;

    /**
     * @var UploadedFile|null The uploaded file instance.
     */
    protected ?UploadedFile $file = null;

    /**
     * @var array|null Metadata for the uploaded file.
     */
    protected ?array $meta = null;

    // ---

    /**
     * Converts a given URL or path to a public asset URL.
     *
     * @param string|null $url The URL or path to convert.
     * @return string|null
     */
    public static function asset(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        return str_starts_with($url, 'http') || str_starts_with($url, 'www') || str_starts_with($url, 'data:')
            ? $url : asset($url);
    }

    /**
     * Uploads a file to the specified disk and returns a Media instance.
     *
     * @param UploadedFile|null $file The file to upload.
     * @param string $directory The directory to store the file in.
     * @param string $label The human-readable label for the file.
     * @param string $disk The storage disk to use.
     * @return static
     */
    public static function upload(?UploadedFile $file, string $directory = '', string $label = '', string $disk = 'public'): static
    {
        $instance = new static();

        if (empty($file)) {
            return $instance;
        }

        try {
            $label = !empty($label) ? $label : 'File';
            $filename = $instance->generateFileName($label, $file->getClientOriginalExtension());
            $path = empty($directory) ? 'uploads' : "uploads/{$directory}";

            if ($file->storeAs($path, $filename, $disk)) {
                $instance->isSuccessful = true;
                $instance->file = $file;
                $instance->meta = [
                    'label' => $label,
                    'name' => $filename,
                    'path' => implode('/', [$path, $filename]),
                    'disk' => $disk,
                ];
            }
        } catch (Throwable $th) {
            $instance->errorMessage = 'Gagal mengunggah berkas.';
        }

        return $instance;
    }

    /**
     * Deletes a file from the specified disk by its storage path.
     *
     * @param string $path The file's storage path.
     * @param string $disk The storage disk.
     * @return bool
     */
    public static function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($path);
    }

    // ---

    /**
     * Deletes the uploaded file associated with this instance.
     *
     * @return bool
     */
    public function drop(): bool
    {
        return Storage::disk($this->meta['disk'])->delete($this->meta['path'] ?? '');
    }

    /**
     * Checks if the upload operation was successful.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    /**
     * Checks if the upload operation had an error.
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return !empty($this->errorMessage);
    }

    /**
     * Retrieves the error message from the upload operation.
     *
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * Retrieves the uploaded file instance.
     *
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * Retrieves the human-readable label of the file.
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->meta['label'] ?? null;
    }

    /**
     * Retrieves the file's original name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->meta['name'] ?? null;
    }

    /**
     * Retrieves the size of the file in bytes.
     *
     * @return bool|int|null
     */
    public function getSize(): bool|int|null
    {
        return $this->file?->getSize();
    }

    /**
     * Retrieves the public path of the uploaded file.
     *
     * @return string|null
     */
    public function getPublicPath(): ?string
    {
        return !empty($this->meta['path']) ? ('storage/' . $this->meta['path']) : null;
    }

    /**
     * Retrieves the storage path of the uploaded file.
     *
     * @return string|null
     */
    public function getStoragePath(): ?string
    {
        return $this->meta['path'] ?? null;
    }

    /**
     * Retrieves the storage disk used.
     *
     * @return string|null
     */
    public function getDisk(): ?string
    {
        return $this->meta['disk'] ?? null;
    }

    /**
     * Serializes the instance to an array of file details.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'disk' => $this->getDisk(),
            'file' => [
                'name' => $this->getName(),
                'extention' => $this->getFile()?->getClientOriginalExtension(),
                'public_path' => $this->getPublicPath(),
                'storage_path' => $this->getStoragePath(),
                'mime' => $this->getFile()?->getClientMimeType(),
            ],
        ];
    }

    // ---

    /**
     * Generates a unique filename.
     *
     * @param string $label
     * @param string $extension
     * @return string
     */
    protected static function generateFileName(string $label = '', string $extension = ''): string
    {
        return Str::slug(Str::lower($label), '-') . '-' . Generator::key($label, true) . '.' . $extension;
    }
}
