<?php

namespace App\Helpers;

use App\Helpers\Generator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class Media extends Helper
{
    protected string $label = '';

    protected ?UploadedFile $file = null;

    protected string $filename = '';

    protected string $path = '';

    protected string $disk = 'public';

    public static function upload(?UploadedFile $file, string $directory = '', string $label = '', string $disk = 'public'): static
    {
        $instance = new static();

        try {
            $label = !empty($label) ? $label : 'File';
            $filename = $instance->generateFileName($label, $file->getClientOriginalExtension());
            $path = empty($directory) ? 'uploads' : "uploads/{$directory}";

            if ($file->storeAs($path, $filename, $disk)) {
                $instance->label = $label;
                $instance->file = $file;
                $instance->name = $filename;
                $instance->path = implode('/', [$path, $filename]);
                $instance->disk = $disk;
            }
        } catch (\Throwable $th) {
            $instance->response()
                ->failure('messages.error.upload_failed', ['resource' => $label])
                ->debug($th);
        }

        return $instance;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getName(): string
    {
        return $this->filename;
    }

    public function getPublicPath(): string
    {
        return 'storage/' . $this->path;
    }

    public function getStoragePath(): string
    {
        return $this->path;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public static function delete(string $path, string $disk = 'public'): LogicResponse
    {
        $instance = new static();
        $path ??= $instance->path ?? '';
        $disk ??= $instance->disk ?? 'public';

        if (Storage::disk($disk)->exists($path) && Storage::disk($disk)->delete($path)) {
            return $instance->response()
                ->success('messages.success.deleted', ['resource' => 'File'])
                ->withPayload([]);
        }

        return $instance->response()
            ->failure('messages.error.not_found', ['resource' => 'File'])
            ->storeLog();
    }

    public function response(): LogicResponse
    {
        $response = new LogicResponse();
        return $response->withType(empty($this->label) ? class_basename($this) : $this->label)
            ->withPayload([
                'data' => [
                    'label' => $this->label,
                    'file' => $this->file,
                    'filename' => $this->filename,
                    'path' => $this->path
                ]
            ]);
    }

    protected static function generateFileName(string $label = '', string $extension = ''): string
    {
        return Str::slug(Str::lower($label), '_').'_'.Generator::key($label, true).'.'.$extension;
    }
}
