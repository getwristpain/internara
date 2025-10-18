<?php

namespace App\Livewire;

use App\Helpers\Media;
use App\Exceptions\AppException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\HasMedia;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

/**
 * @title File Uploader Component
 *
 * This component handles file uploads using Livewire's WithFileUploads trait,
 * providing support for temporary uploads, dynamic validation, and permanent
 * storage using Spatie Media Library. It supports both single and multiple file modes.
 */
class FileUploader extends Component
{
    use WithFileUploads;

    /**
     * @var array Temporary uploaded files bound to the file input.
     * These are Livewire\Features\SupportFileUploads\TemporaryUploadedFile objects.
     */
    public $files = [];

    /**
     * @var Collection Existing media files retrieved from the model using Spatie Media Library.
     */
    public Collection $existingMedia;

    /**
     * @var HasMedia|null The Eloquent model instance that implements HasMedia.
     */
    public ?HasMedia $model = null;

    /**
     * @var string The user-facing label for the file input.
     */
    public string $label = 'document';

    /**
     * @var string The collection name used by Spatie Media Library.
     */
    public string $collectionName = 'default';

    /**
     * @var bool Determines if multiple files can be uploaded.
     */
    public bool $multiple = false;

    /**
     * @var array Custom validation rules passed from the parent component.
     */
    public array $rules = [];

    /**
     * @var string|null Optional hint or descriptive text displayed below the label.
     */
    public ?string $hint = null;

    /**
     * Defines the default validation rules for the file uploads.
     *
     * @return array
     */
    protected function defaultRules(): array
    {
        return [
            'files.*' => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png,gif,webp',
            'files' => 'array',
        ];
    }

    /**
     * Initializes the component properties.
     *
     * @param HasMedia $model The model instance implementing Spatie\MediaLibrary\HasMedia.
     * @param string $collectionName The media collection name.
     * @param bool $isMultiple Whether to allow multiple files.
     * @param array $rules Additional validation rules.
     * @param string $label The display label for the input.
     * @param string|null $hint The input hint/description.
     * @throws \InvalidArgumentException If the provided model does not implement HasMedia (though type-hinting already enforces this).
     */
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
     * Retrieves existing media from the bound model and populates $this->existingMedia.
     * It handles the logic for single vs. multiple mode retrieval.
     *
     * @return void
     */
    protected function initializeExistingMedia()
    {
        if (!$this->model) {
            $this->existingMedia = collect();
            return;
        }

        $mediaQuery = $this->model->getMedia($this->collectionName);

        if (!$this->multiple) {

            $latestMedia = $mediaQuery->sortByDesc('created_at')->first();
            $this->existingMedia = $latestMedia ? collect([$latestMedia]) : collect();
        } else {

            $this->existingMedia = $mediaQuery;
        }
    }

    /**
     * Removes an existing media file record and its physical file from storage.
     *
     * @param int $mediaId The ID of the Spatie Media record to delete.
     * @return void
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

    /**
     * Merges default rules with component-specific rules.
     *
     * @return array
     */
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

    /**
     * Defines custom validation attribute names for better user feedback.
     *
     * @return array
     */
    protected function getFilesAttributes(): array
    {

        $attribute = strtolower($this->label ?? 'document');
        return [
            'files' => $attribute,
            'files.*' => $attribute
        ];
    }

    /**
     * Lifecycle hook executed when the $files property is updated (i.e., when a file is selected).
     * Handles single file mode logic and runs client-side validation.
     *
     * @return void
     */
    public function updatedFiles()
    {

        if (!$this->multiple && count($this->files) > 1) {
            array_shift($this->files);
            $this->files = array_values($this->files);
        }

        $this->validate($this->getValidationRules(), attributes: $this->getFilesAttributes());
    }

    /**
     * Listener method invoked by the parent component to initiate the permanent save process.
     *
     * @return void
     */
    #[On('save-attachments')]
    public function saveAttachments()
    {
        $this->save();
    }

    /**
     * Validates and permanently stores the temporary uploaded files using Spatie Media Library.
     *
     * @return array List of paths or media objects (depending on Media::upload helper return).
     */
    public function save()
    {

        if (empty($this->files)) {

            $this->dispatch('files-saved', paths: []);
            return [];
        }

        $this->validate($this->getValidationRules());

        if (!$this->model) {
            notifyMe()->warning('Model tidak tersedia.');
            return [];
        }

        if (!$this->multiple && $this->existingMedia->isNotEmpty()) {
            $this->existingMedia->first()->delete();
        }

        $paths = [];

        foreach ($this->files as $file) {

            $paths[] = Media::upload(
                $file,
                $this->model,
                $this->label,
                $this->collectionName
            );
        }

        if (!empty($paths)) {
            $this->files = [];
            $this->initializeExistingMedia();
            notifyMe()->success('Berkas berhasil disimpan.');

            $this->dispatch('files-saved', paths: $paths);
        } else {
            notifyMe()->error('Gagal menyimpan berkas.');
        }

        return $paths;
    }

    /**
     * Removes a temporary uploaded file from the $files array, effectively canceling the upload.
     *
     * @param int $index The array index of the file to remove.
     * @return void
     */
    public function removeFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files);
        }
    }

    /**
     * Livewire lifecycle hook to handle exceptions globally within the component.
     * Note: Content is kept in the original language as requested.
     * * @param \Throwable $e
     * @param \Closure $stopPropagation
     * @return void
     */
    public function exception(\Throwable $e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        }
    }

    /**
     * Renders the component's view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.file-uploader');
    }
}
