<?php

namespace App\Services;

use App\Debugger;
use App\Helpers\Helper;
use Closure;
use DateInterval;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Service
{
    use Debugger;

    protected ?Model $model;

    protected string $modelName;

    protected callable|DateInterval|DateTimeInterface|int|null $cacheTTL;

    protected function __construct(?Model $model = null, callable|DateInterval|DateTimeInterface|int|null $cacheTTL = 60)
    {
        $this->model = $model;
        $this->modelName = Str::lower(class_basename($model ?? ''));
        $this->cacheTTL = $cacheTTL;
    }

    protected function collection(array $items = []): Collection
    {
        return new Collection($items);
    }

    protected function getAll(array $with = []): Collection
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->get();
            }

            return $this->model->all();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get all {$this->modelName}(s) data.", $th);
            throw $th;
        }
    }

    protected function getWhere(array $where, array $with = []): Collection
    {
        try {
            if (! empty($with)) {
                return $this->model->where($where)->with($with)->get();
            }

            return $this->model->where($where)->get();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get {$this->modelName}(s) data.", $th);
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

    protected function firstOrInit(array $with = [], array $attributes = []): Model|Collection
    {
        try {
            if (! isset($this->model)) {
                return $this->collection($attributes);
            }

            return $this->first($with) ?? new $this->model($attributes);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to get the first or init {$this->modelName} data.", $th);
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
            $this->debug('error', "Failed to get the first or create new {$this->modelName} data.", $th);
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
            $this->debug('error', "Failed to get with conditions for the first {$this->modelName} data.", $th);
            throw $th;
        }
    }

    protected function create(array $data): ?Model
    {
        try {
            return $this->model->create($data);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to create a new {$this->modelName} data.", $th);
            throw $th;
        }
    }

    protected function update(array $attributes, array $options = []): bool
    {
        try {
            return $this->model->update($attributes, $options);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to update {$this->modelName} data.", $th);
            throw $th;
        }
    }

    protected function updateOrCreate(array $attributes, array $values = []): ?Model
    {
        try {
            return $this->model->updateOrCreate($attributes, $values);
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to update or create a new {$this->modelName} data.", $th);
            throw $th;
        }
    }

    protected function delete(array $where): bool
    {
        try {
            return $this->model->where($where)->delete();
        } catch (\Throwable $th) {
            $this->debug('error', "Failed to delete {$this->modelName} data.");
            throw $th;
        }
    }

    private function generateCacheKey(string $key, array $filters = []): string
    {
        try {
            $filtered = Helper::array_filter($filters);
            $queryString = $filtered ? '.'.http_build_query($filtered) : '';

            return "{$this->modelName}.{$key}{$queryString}";
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to generate cache key.', $th);
            throw $th;
        }
    }

    protected function cachedQuery(Closure $callback, string $key, array $filters, callable|DateInterval|DateTimeInterface|int|null $ttl = 60): mixed
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
}
