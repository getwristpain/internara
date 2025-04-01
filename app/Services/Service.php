<?php

namespace App\Services;

use App\Debugger;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Service
{
    use Debugger;

    protected Model|Collection|null $model;

    protected string $cacheKey;

    protected int $cacheTTL;

    public function __construct(?Model $model = null, int $cacheTTL = 60)
    {
        $this->model = $model ?? new Collection;
        $this->cacheKey = Str::lower(class_basename($model));
        $this->cacheTTL = $cacheTTL;
    }

    protected function queryCached(Closure $callback, string $key, array $filters = [])
    {
        try {
            $cacheKey = $this->generateCacheKey($key, $filters);

            return Cache::remember($cacheKey, $this->cacheTTL, fn() => $callback($this->model));
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to execute cache query.', $th);
            throw $th;
        }
    }

    private function generateCacheKey(string $key, array $filters = []): string
    {
        try {
            $filters = array_filter($filters);
            $filters = empty($filters) ? '' : '.' . http_build_query($filters);

            return "{$this->cacheKey}.{$key}{$filters}";
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to generate cache key.', $th);
            throw $th;
        }
    }

    public function getAll(): Collection
    {
        return $this->queryCached(fn($model) => $model->all(), 'all');
    }

    public function getWhere(array $where, array $with = []): Collection
    {
        return $this->queryCached(fn($model) => $model->with($with)->where($where)->get(), 'find_all', $where);
    }

    public function first(): ?Model
    {
        return $this->queryCached(fn($model) => $model->first(), 'first');
    }

    public function find(string|int $id, array $with = []): ?Model
    {
        return $this->queryCached(fn($model) => $model->with($with)->find($id), 'id', ['id' => $id]);
    }

    public function firstWhere(array $where, array $with = []): ?Model
    {
        return $this->queryCached(fn($model) => $model->with($with)->where($where)->first(), 'find_one', $where);
    }

    public function create(array $data): Model
    {
        try {
            return $this->model->create($data);
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to create model.', $th);
            throw $th;
        }
    }

    public function update(string|int $id, array $data): Model
    {
        try {
            $model = $this->find($id);
            if ($model->update($data)) {
                Cache::forget($this->generateCacheKey('id', ['id' => $id]));
            }

            return $model;
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to update model.', $th);
            throw $th;
        }
    }

    public function updateOrCreate(array $where, array $data): Model
    {
        try {
            $model = $this->model->updateOrCreate($where, $data);
            Cache::forget($this->generateCacheKey('id', ['id' => $model->id]));

            return $model;
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to update or create model.', $th);
            throw $th;
        }
    }

    public function delete(string|int $id): bool
    {
        try {
            $model = $this->find($id);
            if ($model->delete()) {
                Cache::forget($this->generateCacheKey('id', ['id' => $id]));
            }

            return true;
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to delete model.', $th);
            throw $th;
        }
    }

    public function forceDelete(string|int $id): bool
    {
        try {
            $model = $this->find($id);
            if ($model->forceDelete()) {
                Cache::forget($this->generateCacheKey('id', ['id' => $id]));
            }

            return true;
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to force delete model.', $th);
            throw $th;
        }
    }

    public function restore(string|int $id): bool
    {
        try {
            $model = $this->find($id);
            if ($model->restore()) {
                Cache::forget($this->generateCacheKey('id', ['id' => $id]));
            }

            return true;
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to restore model.', $th);
            throw $th;
        }
    }

    public function bulkAction(array $ids, string $action, array $attributes = []): void
    {
        try {
            $query = $this->model->whereIn('id', $ids);

            switch ($action) {
                case 'insert':
                    $this->model->insert($attributes);
                    break;
                case 'upsert':
                    $this->model->upsert($attributes, ['id'], array_keys($attributes[0]));
                    break;
                case 'update':
                    $query->update($attributes);
                    break;
                case 'delete':
                    $query->delete();
                    break;
                case 'restore':
                    $query->restore();
                    break;
                case 'forceDelete':
                    $query->forceDelete();
                    break;
                default:
                    $query->$action();
                    break;
            }
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to perform bulk action.', $th);
            throw $th;
        }
    }

    public function transaction(Closure $callback)
    {
        try {
            return $this->model->getConnection()->transaction($callback);
        } catch (\Throwable $th) {
            $this->debug('error', 'Failed to execute transaction.', $th);
            throw $th;
        }
    }
}
