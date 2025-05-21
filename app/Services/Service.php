<?php

namespace App\Services;

use Closure;
use Throwable;
use App\Helpers\Helper;
use App\Helpers\Debugger;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class Service
{
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
        } catch (Throwable $th) {
            return $this->handleError($th, 'Failed to generate cache key.', default: '');
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
        } catch (Throwable $th) {
            return $this->handleError($th, $th->getMessage());
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

    protected function getAll(array $with = []): ?Collection
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->get();
            }

            return $this->model->all();
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to get all {$this->modelName}(s).");
        }
    }

    protected function getWhere(array $where, array $with = []): ?Collection
    {
        try {
            if (! empty($with)) {
                return $this->model->where($where)->with($with)->get();
            }

            return $this->model->where($where)->get();
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to get {$this->modelName}(s).");
        }
    }

    protected function first(array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->first();
            }

            return $this->model->first();
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to get the first {$this->modelName} record.");
        }
    }

    protected function firstOrInit(array $attributes = [], array $with = []): Model|Collection
    {
        try {
            if (! isset($this->model)) {
                return $this->collection($attributes);
            }

            return $this->first($with) ?? $this->model($attributes);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to get the first or init {$this->modelName}.", default: collect());
        }
    }

    protected function firstOrCreate(array $attributes, array $values = [], array $with = []): Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->firstOrCreate($attributes, $values);
            }

            return $this->model->firstOrCreate($attributes, $values);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to get the first or create new {$this->modelName}.");
        }
    }

    protected function firstWhere(array $where, array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->where($where)->with($with)->first();
            }

            return $this->model->where($where)->first();
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to get with conditions for the first {$this->modelName}.");
        }
    }

    protected function find(int|string $id, array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->find($id);
            }

            return $this->model->find($id);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to find {$this->modelName} with id {$id}.");
        }
    }

    protected function findOrFail(int|string $id, array $with = []): ?Model
    {
        try {
            if (! empty($with)) {
                return $this->model->with($with)->findOrFail($id);
            }

            return $this->model->findOrFail($id);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to find {$this->modelName} with id {$id}.");
        }
    }

    protected function exists(array $where): bool
    {
        try {
            return $this->model->where($where)->exists();
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to check if {$this->modelName} exists.", default: false);
        }
    }

    protected function create(array $attributes): ?Model
    {
        try {
            return $this->model->create($attributes);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to create a new {$this->modelName}.");
        }
    }

    protected function update(array $where, array $attributes, array $options = []): bool
    {
        try {
            return $this->model->where($where)->update($attributes, $options);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to update {$this->modelName}.", default: false);
        }
    }

    protected function updateFirst(array $attributes, array $where = [], array $options = []): bool
    {
        try {
            if (empty($where)) {
                return $this->model->first()->update($attributes, $options);
            }

            return $this->model->where($where)->first()->update($attributes, $options);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to update the first {$this->modelName}.", default: false);
        }
    }

    protected function updateOrCreate(array $attributes, array $values = []): ?Model
    {
        try {
            return $this->model->updateOrCreate($attributes, $values);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to update or create a new {$this->modelName}.");
        }
    }

    protected function delete(int|string|array $where): bool
    {
        try {
            if (is_array($where)) {
                return $this->model->where($where)->delete();
            }

            return $this->model->find($where)->delete();
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to delete {$this->modelName}", default: false);
        }
    }

    protected function destroy(int|string $ids): bool
    {
        try {
            return $this->model->destroy($ids);
        } catch (Throwable $th) {
            return $this->handleError($th, "Failed to destroy {$this->modelName}", default: false);
        }
    }

    protected function handleError(Throwable $exception, string $message = '', array $context = [], array $properties = [], mixed $default = null): mixed
    {
        Debugger::debug($exception, $message, $context, $properties)->storeLog();

        return $default;
    }
}
