<?php

namespace App\Models;

use App\Helpers\SettingCaster;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'label',
        'description',
    ];

    /**
     * Accessor for the 'value' attribute.
     * Casts the stored string value to its original PHP type based on the 'type' column.
     *
     * @param string $value The raw string value from the database.
     * @return mixed
     */
    public function getValueAttribute($value): mixed
    {
        return SettingCaster::cast($value, $this->type);
    }

    /**
     * Mutator for the 'value' attribute.
     * Automatically sets the 'type' attribute and converts the value to a string for storage.
     *
     * @param mixed $value The incoming value (string, int, array, bool, etc.).
     * @return void
     */
    public function setValueAttribute($value): void
    {
        $originalType = $this->determineType($value);

        $this->attributes['type'] = $originalType;

        $this->attributes['value'] = SettingCaster::prepareForStorage($value);
    }

    /**
     * Determines the data type string to be stored in the 'type' column.
     *
     * @param mixed $value
     * @return string
     */
    protected function determineType($value): string
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_array($value) || is_object($value)) {
            return 'json';
        }

        return gettype($value);
    }
}
