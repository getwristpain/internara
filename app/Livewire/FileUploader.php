<?php

namespace App\Livewire;

use App\Helpers\Media;
use App\Exceptions\AppException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\HasMedia;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class FileUploader extends Component
{
    use WithFileUploads;

    public $files = []; // Untuk Temporary Uploads (File Baru)
    public Collection $existingMedia; // Untuk Media dari database (File Lama)
    public ?HasMedia $model = null;
    public string $label = 'document';
    public string $collectionName = 'default';
    public bool $multiple = false;
    public array $rules = [];
    public ?string $hint = null;

    protected function defaultRules(): array
    {
        return [
            'files.*' => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png,gif,webp',
            'files' => 'array',
        ];
    }

    public function mount(HasMedia $model, string $collectionName = 'default', bool $isMultiple = false, array $rules = [], string $label = 'document', ?string $hint = null)
    {
        $this->model = $model;
        $this->collectionName = $collectionName;
        $this->multiple = $isMultiple;
        $this->rules = $rules;
        $this->label = $label;
        $this->hint = $hint;
        $this->existingMedia = collect();

        if (!$this->multiple) {
            $this->rules['files'] = array_merge($this->rules['files'] ?? ['nullable'], ['max:1']);
        }

        $this->initializeExistingMedia();
    }

    /**
     * Mengambil media yang sudah ada dari model sesuai dengan collectionName.
     */
    protected function initializeExistingMedia()
    {
        // Pastikan model sudah ada dan merupakan HasMedia
        if (!$this->model) {
            $this->existingMedia = collect();
            return;
        }

        $mediaQuery = $this->model->getMedia($this->collectionName);

        if (!$this->multiple) {
            // Mode Single: Ambil yang paling terakhir (latest)
            $latestMedia = $mediaQuery->sortByDesc('created_at')->first();
            $this->existingMedia = $latestMedia ? collect([$latestMedia]) : collect();
        } else {
            // Mode Multiple: Ambil semuanya
            $this->existingMedia = $mediaQuery;
        }
    }

    /**
     * Menghapus media lama yang sudah tersimpan di Spatie Media.
     */
    public function removeExistingMedia(int $mediaId)
    {
        $mediaItem = $this->existingMedia->firstWhere('id', $mediaId);

        if ($mediaItem) {
            $mediaItem->delete();

            $this->existingMedia = $this->existingMedia->reject(function ($media) use ($mediaId) {
                return $media->id === $mediaId;
            });

            notifyMe()->success('Berkas berhasil dihapus.');
        } else {
            notifyMe()->error('Berkas lama tidak ditemukan.');
        }
    }

    protected function getValidationRules(): array
    {
        $rules = $this->defaultRules();

        if (isset($this->rules['files.*'])) {
            $rules['files.*'] = $this->rules['files.*'];
        }

        if (isset($this->rules['files'])) {
            $rules['files'] = $this->rules['files'];
        }

        return $rules;
    }

    public function updatedFiles()
    {
        if (!$this->multiple && count($this->files) > 1) {
            array_shift($this->files);
            $this->files = array_values($this->files);
        }

        $this->validate($this->getValidationRules());
    }

    #[On('save-attachments')]
    public function saveAttachments()
    {
        $this->save();
    }

    /**
     * Menyimpan file baru ke Spatie Media Library.
     */
    public function save()
    {
        $this->validate($this->getValidationRules());

        if (empty($this->files)) {
            // Tidak perlu notifikasi jika tidak ada yang disimpan
            // notifyMe()->warning('Tidak ada berkas baru untuk disimpan.');
            return [];
        }

        if (!$this->model) {
            notifyMe()->warning('Model tidak tersedia.');
            return [];
        }

        // Mode Single: Hapus media lama sebelum menyimpan yang baru
        if (!$this->multiple && $this->existingMedia->isNotEmpty()) {
            $this->existingMedia->first()->delete();
        }


        $paths = [];

        foreach ($this->files as $file) {
            // Asumsi Media::upload mengembalikan path/Spatie Media object
            $paths[] = Media::upload(
                $file,
                $this->model,
                $this->label,
                $this->collectionName
            );
        }

        if (!empty($paths)) {
            $this->files = [];
            $this->initializeExistingMedia(); // Muat ulang existing media
            notifyMe()->success('Berkas berhasil disimpan.');
            $this->dispatch('files-saved', paths: $paths);
        } else {
            notifyMe()->error('Gagal menyimpan berkas.');
        }

        return $paths;
    }

    /**
     * Menghapus file sementara (temporary uploaded file).
     */
    public function removeFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files);
        }
    }

    public function exception(\Throwable $e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        }
    }

    public function render()
    {
        return view('livewire.file-uploader');
    }
}
