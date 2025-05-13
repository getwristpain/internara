<?php

namespace App;

use App\Helpers\Formatter;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasStatus
{
    public static function bootHasStatus()
    {
        static::created(function ($model) {
            Status::where('model', class_basename($model))->delete();

            if (property_exists($model, 'initialStatuses')) {
                foreach ($model->initialStatuses as $type => $statuses) {
                    foreach ($statuses as $status) {
                        $statuses = $model->statusables();
                        $created = Status::create(array_merge($status, [
                            'type' => is_string($type) ? $type : Formatter::snakecase(class_basename($model)),
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
        return $this->morphToMany(Status::class, 'statusable');
    }

    public function statuses(string $type = ''): Collection
    {
        if (! empty($type)) {
            return $this->statusables()->where('type', $type)->get();
        }

        return $this->statusables()->get();
    }

    public function getStatus(string $name, string $type = ''): ?Status
    {
        if (! empty($type)) {
            return $this->statusables()->where(['type' => $type, 'name' => $name])->first();
        }

        return $this->statusables()->where(['type' => Formatter::snakecase(class_basename($this)), 'name' => $name])->first();
    }

    public function setStatus(string $name, string $type = '', array $attributes = []): bool
    {
        $status = $this->getStatus($name, $type);

        if (! $status) {
            return false;
        }

        $status->update($attributes);

        return true;
    }

    public function switchStatus(string $name, string $type = ''): bool
    {
        $statuses = $this->statuses($type);
        Status::whereIn('id', $statuses->pluck('id'))
            ->update(['is_active' => false]);

        return $this->setStatus($name, $type, ['is_active' => true]);
    }

    public function switchDefaultStatus(string $name, string $type = ''): bool
    {
        $statuses = $this->statuses($type);
        Status::whereIn('id', $statuses->pluck('id'))
            ->update(['is_default' => false]);

        return $this->setStatus($name, $type, ['is_default' => true]);
    }
}
