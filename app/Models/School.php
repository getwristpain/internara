<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class School extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'principal_name',
        'address',
        'postal_code',
        'email',
        'phone',
        'fax',
        'website',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected function casts(): array
    {
        return [
            'address' => 'array'
        ];
    }

    public function getFullAddressAttribute(): ?string
    {
        $fullAddress = !empty($this->address)
            ? implode(', ', array_filter($this->address, fn ($i) => !empty($i)))
            : '';

        return !empty($fullAddress)
            ? trim($fullAddress . '. ' . $this->postal_code)
            : $this->postal_code;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('school_logo') ?? null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('school_logo')
            ->singleFile()
            ->useDisk('public');
    }

    public function saveLogo(?UploadedFile $file)
    {
        if (!$file) {
            return null;
        }

        $media = $this->addMedia($file)
            ->toMediaCollection('school_logo');

        return $media;
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
