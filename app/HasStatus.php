<?php

namespace App;

use App\Helpers\Helper;
use App\Helpers\Sanitizer;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasStatus
{
    public static function bootHasStatus()
    {
        static::created(function ($model) {
            if (property_exists($model, 'initialStatuses')) {
                foreach ($model->initialStatuses as $type => $statuses) {
                    foreach ($statuses as $status) {
                        $statuses = $model->statusables();
                        $created = Status::updateOrCreate(array_merge($status, [
                            'type' => is_string($type) ? $type : '',
                        ]));

                        $model->statusables()->syncWithoutDetaching($created);
                    }
                }
            }
        });
    }

    /**
     * Return all statuses of this model.
     */
    public function statusables(): MorphToMany
    {
        return $this->morphToMany(Status::class, 'statusable')->withTimestamps();
    }

    /**
     * Get statuses by type or all statuses if type is empty.
     */
    public function getStatuses(string $type = ''): ?Collection
    {
        $type = Sanitizer::sanitize($type, 'string');

        return empty($type) ? $this->statusables()->get() : $this->statusables()->where('type', $type)->get();
    }

    /**
     * Get a single status by name and type.
     */
    public function getStatus(string $name = '', string $type = ''): ?Status
    {
        [$name, $type] = Sanitizer::sanitize([$name, $type], 'string');

        $conditions = Helper::array_filter(['type' => $type, 'name' => $name]);

        return empty($conditions) ? $this->statusables()->first() : $this->statusables()->where($conditions)->first();
    }

    /**
     * Update a status by conditions.
     */
    public function updateStatus(array $where, array $attributes = []): bool
    {
        $attributes = $this->sanitizeAttributes($attributes);
        $status = $this->statusables()->where($where)->first();

        if (! $status) {
            return false;
        }

        return $status->update($attributes);
    }

    /**
     * Toggle a specific column value for a status.
     */
    public function markStatus(string $name, string $type = '', string $column = 'flag'): bool
    {
        $status = $this->getStatus($name, $type);

        if (! $status) {
            return false;
        }

        return $status->update([$column => (! $status->{$column})]);
    }

    /**
     * Set a status with matched name and unset others in the same type.
     */
    public function switchStatus(string $name, string $type = '', string $column = 'flag'): bool
    {
        $statuses = $this->getStatuses($type);

        if ($statuses->isEmpty()) {
            return false;
        }

        Status::whereIn('id', $statuses->pluck('id'))->update([$column => false]);

        return $this->markStatus($name, $type, $column);
    }

    /**
     * Set a status as default and unset others in the same type.
     */
    public function setDefaultStatus(string $name, string $type = ''): bool
    {
        return $this->switchStatus($name, $type, 'is_default');
    }

    /**
     * Sanitize attributes for status updates.
     */
    private function sanitizeAttributes(array $attributes): array
    {
        return Sanitizer::sanitize($attributes, [
            'name' => 'string',
            'type' => 'string',
            'label' => 'string',
            'description' => 'string',
            'priority' => 'string',
            'color' => 'string',
            'icon' => 'string',
            'flag' => 'bool',
            'is_default' => 'bool',
        ]);
    }
}
