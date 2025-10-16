<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class School extends Model implements HasMedia
{
    use HasFactory;
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
