<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
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
        'logo_url',
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

    public function getFullAddress(): string
    {
        $fullAddress = !empty($this->address)
            ? implode(', ', array_filter($this->address, fn ($i) => !empty($i)))
            : '';

        return !empty($fullAddress)
            ? trim($fullAddress . '. ' . $this->postal_code)
            : $this->postal_code;
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
