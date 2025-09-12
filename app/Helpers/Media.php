<?php

namespace App\Helpers;

use App\Helpers\Generator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class Media extends Helper
{
    protected ?LogicResponse $response = null;

    protected ?UploadedFile $file = null;

    protected ?array $meta = null;

    public static function asset(?string $url): ?string
    {
        if ($url === null) {
            return null;
        }

        return str_starts_with($url, 'http') || str_starts_with($url, 'www') || str_starts_with($url, 'data:')
            ? $url : asset($url);
    }

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
                $instance->file = $file;
                $instance->meta = [
                    'label' => $label ?: null,
                    'name' => $filename ?: null,
                    'path' => implode('/', [$path, $filename]) ?: null,
                    'disk' => $disk ?: null
                ];

                $instance->response = $instance->response()
                    ->success('Berkas berhasil diunggah.');
            }
        } catch (\Throwable $th) {
            $instance->response = $instance->response()
                ->error("Gagal mengunggah berkas.")
                ->withCode('ERROR_UPLOAD_FAILED')
                ->debug($th);
        }

        return $instance;
    }

    public static function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->delete($path);
    }

    public function drop(): bool
    {
        return Storage::disk($this->meta['disk'])->delete($this->meta['path'] ?? '');
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file ?? null;
    }

    public function getLabel(): ?string
    {
        return $this->meta['label'] ?? null;
    }

    public function getName(): ?string
    {
        return $this->meta['name'] ?? null;
    }

    public function getSize(): bool|int|null
    {
        return $this->file?->getSize();
    }

    public function getPath(string $type = ''): ?string
    {
        return match ($type) {
            'storage' => $this->getStoragePath(),
            default => $this->getPublicPath(),
        };
    }

    public function getPublicPath(): ?string
    {
        return !empty($this->meta['path']) ? ('storage/' . $this->meta['path']) : null;
    }

    public function getStoragePath(): ?string
    {
        return $this->meta['path'] ?? null;
    }

    public function getDisk(): ?string
    {
        return $this->meta['disk'] ?? null;
    }

    public function getResponse(): LogicResponse
    {
        return $this->response ?? $this->response();
    }

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

    protected static function generateFileName(string $label = '', string $extension = ''): string
    {
        return Str::slug(Str::lower($label), '-') . '-' . Generator::key($label, true).'.'.$extension;
    }
}
