<?php

namespace App\Helpers;

use App\Helpers\Helper;
use App\Helpers\Debugger;
use App\Helpers\Generator;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class Media extends Helper
{
    protected ?UploadedFile $file = null;

    protected string $label = '';

    protected string $filename = '';

    protected string $path = '';

    public static function upload(?UploadedFile $file, string $directory = '', string $label = '', string $storage = 'public'): static
    {
        $instance = new static();

        try {
            $filename = $instance->generateFileName($label, $file->getClientOriginalExtension());
            $path = empty($directory) ? 'uploads' : "uploads/{$directory}";

            if ($file->storeAs($path, $filename, $storage)) {
                $instance->file = $file;
                $instance->label = $label;
                $instance->name = $filename;
                $instance->path = implode('/', ['storage', $path, $filename]);
            }
        } catch (\Throwable $th) {
            Debugger::debug($th, 'Failed to upload file.', ['file' => $file]);
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

    public function getPath(): string
    {
        return $this->path;
    }

    protected static function generateFileName(string $label = '', string $extension = ''): string
    {
        return Str::slug(Str::lower($label), '_').'_'.Generator::key($label, true).'.'.$extension;
    }
}
