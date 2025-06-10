<?php

namespace App\Helpers;

use App\Contracts\EntityContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * @template TModel of Model
 */
abstract class ModelWrapper extends Helper implements EntityContract
{
    protected Model|Builder|null $model = null;
    protected array $data = [];
    protected string $type = 'Record';
    protected array $permissions = ['create', 'read', 'update', 'delete'];

    /**
     * @param Model|null $model
     * @param array $permissions
     * @param array $defaultData
     * @param array $relations
     */
    public static function make(?Model $model, array $permissions = [], array $defaultData = [], array $relations = []): static
    {
        $instance = new static();
        $instance->setModel($model, $relations);
        $instance->setPermissions($permissions);
        $instance->setData($defaultData);

        return $instance;
    }

    public function query(): ?Model
    {
        return $this->model;
    }

    public function with(array $relations = []): static
    {
        return $this->setModel($this->model, $relations);
    }

    public function withTrashed(): static
    {
        $this->ensureSupportsSoftDeletes();
        return $this->setModel($this->model->withTrashed());
    }

    public function onlyTrashed(): static
    {
        $this->ensureSupportsSoftDeletes();
        return $this->setModel($this->model->onlyTrashed());
    }

    public function isPermitted(string|array $permission = ''): bool
    {
        if (empty($permission)) {
            return true;
        }
        $permissions = is_array($permission) ? $permission : [$permission];
        foreach ($permissions as $perm) {
            if (!in_array($perm, $this->permissions)) {
                return false;
            }
        }
        return true;
    }

    public function isNotPermitted(string|array $permission = ''): bool
    {
        return !$this->isPermitted($permission);
    }

    public function count(): int
    {
        return $this->toCollection()->count();
    }

    public function toCollection(): Collection
    {
        if ($this->isPermitted('single')) {
            return new Collection();
        }
        return new Collection($this->data);
    }

    public function toAttributes(): Attribute
    {
        if ($this->isNotPermitted('single')) {
            return new Attribute();
        }
        return new Attribute($this->data);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function response(): LogicResponse
    {
        $response = new LogicResponse();
        $response->withType($this->type)
            ->withPayload($this->data)
            ->operator($this);

        return $response;
    }

    public function find(string|int $id): ?Attribute
    {
        $this->ensureNotForbiddenAction('FIND action', 'read');
        if ($this->isPermitted('single')) {
            return $this->first();
        }
        $model = $this->model->find($id);
        if (!$model) {
            return null;
        }
        return $this->setData($model)->toAttributes();
    }

    public function first(array $where = []): ?Attribute
    {
        $this->ensureNotForbiddenAction('FIRST action', 'read');
        $model = $this->isPermitted('single')
            ? $this->model->first()
            : $this->model->where($where)->first();
        if (!$model) {
            return null;
        }
        return $this->setData($model)->toAttributes();
    }

    public function firstOrFail(array $where = []): ?Attribute
    {
        $this->ensureNotForbiddenAction('FIRST or FAIL action', 'read');
        try {
            $model = $this->isPermitted('single')
                ? $this->model->firstOrFail()
                : $this->model->where($where)->firstOrFail();
        } catch (\Throwable $e) {
            return null;
        }
        return $this->setData($model)->toAttributes();
    }

    public function firstOrCreate(array $attributes = [], array $values = []): ?Attribute
    {
        $this->ensureNotForbiddenAction('FIRST or CREATE action', ['read', 'create'], 'single');
        $model = $this->model->firstOrCreate($this->filterFillable($attributes), $this->filterFillable($values));
        return $this->setData($model)->toAttributes();
    }

    /**
     * @param callable(Model|Builder):Builder $conditions
     */
    public function search(callable $conditions): ?Collection
    {
        $this->ensureNotForbiddenAction('SEARCH action', ['read'], 'single');
        $builder = $conditions($this->model);
        if (!($builder instanceof Builder)) {
            throw new \InvalidArgumentException('Callback for search() must return an instance of Eloquent\Builder');
        }
        $result = $builder->get();
        return $this->setData($result)->toCollection();
    }

    public function get(array $where = []): Attribute|Collection|null
    {
        $this->ensureNotForbiddenAction('GET action', 'read');
        if ($this->isPermitted('single')) {
            return $this->first();
        }
        $result = $this->model->where($where)->get();
        return $this->setData($result)->toCollection();
    }

    public function set(string|array $key, mixed $value = ''): LogicResponse
    {
        $this->ensureNotForbiddenAction('SET action', ['single', 'update']);
        $attributes = is_string($key) ? [$key => $value] : $key;
        $attributes = $this->filterFillable($attributes);

        $model = $this->model->first();
        if (!$model && $this->isPermitted('create')) {
            return $this->create($attributes);
        }
        if (!$model || !$model->update($attributes)) {
            return $this->response()->failure("Failed to set {$this->type}");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been set up successfully.");
    }

    public function create(array $attributes = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('CREATE action', 'create');
        $attributes = $this->filterFillable($attributes);
        $model = $this->model->create($attributes);
        if (!$model) {
            return $this->response()->failure("Failed to create {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been created successfully.");
    }

    public function insert(array $data = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('INSERT action', 'create', 'single');
        $values = [];
        foreach ($data as $item) {
            $values[] = $this->filterFillable($item);
        }
        $inserted = $this->model->insert($values);
        if (!$inserted) {
            return $this->response()->failure("Failed to insert {$this->type}(s)");
        }
        $this->setData($data);
        return $this->response()->success("{$this->type}(s) have been inserted successfully.");
    }

    public function update(array $where = [], array $attributes = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('UPDATE action', 'update');
        $attributes = $this->filterFillable($attributes);
        $model = $this->model->where($where)->first();
        if (!$model) {
            return $this->response()->failure("Failed to update {$this->type}.");
        }
        if (!$model->update($attributes)) {
            return $this->response()->failure("Failed to update {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been updated successfully.");
    }

    public function updateById(string|int $id, array $attributes = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('UPDATE action', 'update', 'single');
        $attributes = $this->filterFillable($attributes);
        $model = $this->model->find($id);
        if (!$model) {
            return $this->response()->failure("Failed to update {$this->type}.");
        }
        if (!$model->update($attributes)) {
            return $this->response()->failure("Failed to update {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been updated successfully.");
    }

    public function updateOrCreate(array $where = [], array $attributes = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('UPDATE action', ['create', 'update']);
        $attributes = $this->filterFillable($attributes);
        if ($this->isPermitted('single')) {
            return $this->set($attributes);
        }
        $model = $this->model->updateOrCreate($where, $attributes);
        if (!$model) {
            return $this->response()->failure("Failed to update {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been updated successfully.");
    }

    public function delete(array $where = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('DELETE action', 'delete');
        $model = $this->model->where($where)->first();
        if (!$model || !$model->delete()) {
            return $this->response()->failure("Failed to delete {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been deleted successfully.");
    }

    public function deleteByIds(string|int|array $ids): LogicResponse
    {
        $this->ensureNotForbiddenAction('DELETE action', 'delete');
        $ids = is_array($ids) ? $ids : [$ids];
        $deleted = $this->model->whereIn('id', $ids)->delete();
        if (!$deleted) {
            return $this->response()->failure("Failed to delete {$this->type}(s) by IDs.");
        }
        return $this->response()->success("{$this->type}(s) have been deleted successfully.");
    }

    public function batchDelete(string $whereIn, array $values = []): LogicResponse
    {
        $this->ensureNotForbiddenAction('BATCH DELETE action', 'delete');
        $deleted = $this->model->whereIn($whereIn, $values)->delete();
        if (!$deleted) {
            return $this->response()->failure("Failed to batch delete {$this->type}(s).");
        }
        return $this->response()->success("{$this->type}(s) have been batch deleted successfully.");
    }

    public function forceDelete(): LogicResponse
    {
        $this->ensureNotForbiddenAction('FORCE DELETE action', 'delete');
        $this->ensureSupportsSoftDeletes();
        $model = $this->model->first();
        if (!$model || !$model->forceDelete()) {
            return $this->response()->failure("Failed to force delete {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been force deleted successfully.");
    }

    public function restore(): LogicResponse
    {
        $this->ensureNotForbiddenAction('RESTORE action', 'update');
        $this->ensureSupportsSoftDeletes();
        $model = $this->model->withTrashed()->first();
        if (!$model || !$model->restore()) {
            return $this->response()->failure("Failed to restore {$this->type}.");
        }
        $this->setData($model);
        return $this->response()->success("{$this->type} has been restored successfully.");
    }

    /**
     * @param callable(Model|Builder):Builder $callback
     */
    public function paginate(callable $callback, int $perPage = 15, array $columns = ['*']): Collection
    {
        $this->ensureNotForbiddenAction('PAGINATE action', 'read');
        $builder = $callback($this->model);
        if (!($builder instanceof Builder)) {
            throw new \InvalidArgumentException('Callback for paginate() must return an instance of Eloquent\Builder');
        }
        $result = $builder->paginate($perPage, $columns);
        return $this->setData($result->items())->toCollection();
    }

    public function transaction(?callable $callback, int $attempts = 1): mixed
    {
        return \DB::transaction($callback, $attempts);
    }

    public function setModel(Model|Builder|null $model = null, array $with = []): static
    {
        $this->ensureIsValidModel($model);
        if (!empty($with)) {
            $model = $model->with($with);
        }
        $this->model = $model;
        return $this;
    }

    public function setPermissions(array $permissions = []): static
    {
        $this->permissions = !empty($permissions) ? $permissions : $this->permissions;
        return $this;
    }

    public function setData(Model|Collection|Attribute|array $data = []): static
    {
        if ($data instanceof Model || $data instanceof Attribute) {
            $data = $data?->toArray() ?? [];
        } elseif ($data instanceof Collection) {
            $data = $data->toArray();
        }
        $this->data = $data;
        return $this;
    }

    protected function ensureIsValidModel(Model|Builder|null $model = null): void
    {
        if (is_a($model, Model::class) || is_a($model, Builder::class)) {
            return;
        }
        Debugger::debug(new \InvalidArgumentException('The model must be an instance of Illuminate\Database\Eloquent\Model'))->throw();
        exit();
    }

    protected function filterFillable(array $data = []): array
    {
        return Helper::filter($data, $this->model->getFillable());
    }

    protected function ensureNotForbiddenAction(string $action = '', string|array $permittedPermission = '', string|array $orNotPermittedPermission = ''): void
    {
        if ($this->isNotPermitted($permittedPermission) || $this->isPermitted($orNotPermittedPermission)) {
            $this->blockAction($action);
        }
    }

    protected function blockAction(string $action): never
    {
        $action = $action ?: 'action';
        Debugger::debug(new AuthorizationException("The {$action} on {$this->type} is not permitted."))->throw();
        exit();
    }

    protected function ensureSupportsSoftDeletes(): void
    {
        if (!in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($this->model))) {
            Debugger::debug(new \LogicException("Model {$this->type} does not support soft deletes."))->throw();
            exit();
        }
    }
}
