<?php

namespace App\Models;

use App\Helpers\Media;
use App\Observers\SchoolObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SchoolObserver::class)]
class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'telp',
        'fax',
        'address',
        'postal_code',
        'principal_name',
        'website',
        'logo_url',
    ];

    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => Media::asset($value)
        );
    }
}
