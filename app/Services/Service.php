<?php

namespace App\Services;

use Closure;
use App\Debugger;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Service
{
    use Debugger;

    protected ?Model $model;
    protected string $cacheKey;
    protected int $cacheTTL;

    protected function __construct(?Model $model = null, int $cacheTTL = 60)
    {
        $this->model = $model;
        $this->cacheKey = Str::lower(class_basename($model));
        $this->cacheTTL = $cacheTTL;
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
        return $this->model->create($data);
    }

    public function update(string|int $id, array $data): Model
    {

        $model = $this->find($id);
        if ($model->update($data)) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return $model;
    }

    public function updateOrCreate(array $where, array $data): Model
    {
        $model = $this->model->updateOrCreate($where, $data);
        Cache::forget($this->generateCacheKey('id', ['id' => $model->id]));

        return $model;
    }

    public function delete(string|int $id): bool
    {
        $model = $this->find($id);
        if ($model->delete()) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return true;
    }

    public function forceDelete(string|int $id): bool
    {
        $model = $this->find($id);
        if ($model->forceDelete()) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return true;
    }

    public function restore(string|int $id): bool
    {
        $model = $this->find($id);
        if ($model->restore()) {
            Cache::forget($this->generateCacheKey('id', ['id' => $id]));
        }

        return true;
    }

    public function bulkAction(array $ids, string $action, array $attributes = []): void
    {
        $query = $this->model->whereIn('id', $ids);

        switch ($action) {
            case 'insert':
                $this->model->insert($attributes);
                break;
            case 'upsert':
                $this->model->upsert($attributes, ['id'], array_keys($attributes[0]));
                break;
            case 'update':
                $query->update();
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
    }

    public function transaction(Closure $callback)
    {
        return $this->model->getConnection()->transaction($callback);
    }

    protected function queryCached(Closure $callback, string $key, array $filters = [])
    {
        $cacheKey = $this->generateCacheKey($key, $filters);
        return Cache::remember($cacheKey, $this->cacheTTL, fn() => $callback($this->model));
    }

    protected function rules(array $attributes = []): array
    {
        return [];
    }

    protected function validate(?array $data = null, array $rules = [], array $message = [], array $attributes = []): array
    {
        $data = $data ?? $this->model?->toArray();
        $rules = array_merge($this->rules($data), $rules);

        return validator($data, $rules, $message, $attributes)->validate();
    }

    private function generateCacheKey(string $key, array $filters = []): string
    {
        $cacheFilters = empty($filters) ? '' : md5(serialize($filters));
        return implode(':', [$this->cacheKey, $key, $cacheFilters]);
    }
}
