<?php

namespace App\Services;

use App\Debugger;
use App\Helpers\Helper;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

abstract class Service
{
    use Debugger;

    protected ?Model $model;

    protected string $modelName;

    protected int $cacheTTL = 60;

    protected function __construct(?Model $model = null, int $cacheTTL = 60)
    {
        $this->model = $model;
        $this->modelName = Str::lower(class_basename($model ?? 'record'));
        $this->cacheTTL = $cacheTTL;
    }

    public function __toString(): string
    {
        return Helper::stringify(Helper::objectToArray($this));
    }

    private function generateCacheKey(string $key, array $filters = []): string
    {
        try {
            $filtered = Helper::filter($filters);
            $queryString = $filtered ? '.'.http_build_query($filtered) : '';

            return "{$this->modelName}.{$key}{$queryString}";
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to generate cache key.', $th);
            throw $th;
        }
    }

    protected function cachedQuery(Closure $callback, string $key, array $filters, int $ttl = 60): mixed
    {
        try {
            return Cache::remember(
                $this->generateCacheKey($key, $filters),
                $ttl ?? $this->cacheTTL,
                fn () => $callback($this->model)
            );
        } catch (\Throwable $th) {
            $this->debug('error', $th->getMessage(), $th);
            throw $th;
        }
    }

    protected function model(array $attributes = []): ?Model
    {
        return $this->model->fill($attributes);
    }

    protected function collection(array $items = []): Collection
    {
        return new Collection($items);
    }

    protected function getAttributes(): array
    {
        return $this->model->getAttributes();
    }

    protected function get(array $with = [], array $where = []): ?Collection
    {
        if (! empty($where)) {
            return $this->getWhere($where, $with);
        }

        return $this->getAll($with);
    }

    protected function set(array $attributes, array $options = []): bool
    {
        try {
            $first = $this->first();

            if (! $first && ! $first->update($attributes, $options)) {
                return false;
            }

            $this->log();

            return true;
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to set {$this->model}.", $th);
            throw $th;
        }
    }

    protected function getAll(array $with = []): ?Collection
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->get();
            }

            return $this->model->all();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get all {$this->modelName}(s).", $th);
            throw $th;
        }
    }

    protected function getWhere(array $where, array $with = []): ?Collection
    {
        try {
            if (! empty($with)) {
                return $this->model->where($where)->with($with)->get();
            }

            return $this->model->where($where)->get();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get {$this->modelName}(s).", $th);
            throw $th;
        }
    }

    protected function first(array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->first();
            }

            return $this->model->first();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get the first {$this->modelName} record.");
            throw $th;
        }
    }

    protected function firstOrInit(array $attributes = [], array $with = []): Model|Collection
    {
        try {
            if (! isset($this->model)) {
                return $this->collection($attributes);
            }

            return $this->first($with) ?? $this->model($attributes);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get the first or init {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function firstOrCreate(array $attributes, array $values = [], array $with = []): Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->firstOrCreate($attributes, $values);
            }

            return $this->model->firstOrCreate($attributes, $values);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get the first or create new {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function firstWhere(array $where, array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->where($where)->with($with)->first();
            }

            return $this->model->where($where)->first();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get with conditions for the first {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function find(int|string $id, array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->find($id);
            }

            return $this->model->find($id);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to find {$this->modelName} with id {$id}.", $th);
            throw $th;
        }
    }

    protected function findOrFail(int|string $id, array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->findOrFail($id);
            }

            return $this->model->findOrFail($id);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to find {$this->modelName} with id {$id}.", $th);
            throw $th;
        }
    }

    protected function exists(array $where): bool
    {
        try {
            return $this->model->where($where)->exists();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to check if {$this->modelName} exists.", $th);
            throw $th;
        }
    }

    protected function create(array $attributes): ?Model
    {
        try {
            return $this->model->create($attributes);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to create a new {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function update(array $where, array $attributes, array $options = []): bool
    {
        try {
            return $this->model->where($where)->update($attributes, $options);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to update {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function updateFirst(array $attributes, array $where = [], array $options = []): bool
    {
        try {
            if (empty($where)) {
                return $this->model->first()->update($attributes, $options);
            }

            return $this->model->where($where)->first()->update($attributes, $options);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to update the first {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function updateOrCreate(array $attributes, array $values = []): ?Model
    {
        try {
            return $this->model->updateOrCreate($attributes, $values);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to update or create a new {$this->modelName}.", $th);
            throw $th;
        }
    }

    protected function delete(int|string|array $where): bool
    {
        try {
            if (is_array($where)) {
                return $this->model->where($where)->delete();
            }

            return $this->model->find($where)->delete();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to delete {$this->modelName}.");
            throw $th;
        }
    }

    protected function destroy(int|string $ids): bool
    {
        try {
            return $this->model->destroy($ids);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to destroy {$this->modelName}(s).");
            throw $th;
        }
    }
}
