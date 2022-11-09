<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class EloquentService
{
    protected $model;

    public function __construct(Model $model){
        $this->model = $model;
    }



    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection {
        return $this->model->with($relations)->get($columns);
    }



    public function where($search = [], $page = null, $perPage = 15, array $columns = ['*'], array $relations = []){
        return $this->model->customWhere($search)->with($relations)->paginate($perPage, $columns, 'page', $page);;
    }

    public function paginate($page = null, $perPage = 15, array $columns = ['*'], array $relations = []): LengthAwarePaginator{
        return $this->model->with($relations)->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection{
        return $this->model->allTrashed()->get();
    }

    /**
     * Find model by id.
     *
     * @param string $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        string  $modelId,
        array   $columns = ['*'],
        array   $relations = [],
        array   $appends = []
    ): ?Model {

        return $this->model->findById($modelId, $columns, $relations, $appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param string $modelId
     * @return Model
     */
    public function findTrashedById(string $modelId): ?Model
    {
        return $this->model->findTrashedById($modelId);
    }

    /**
     * Find only trashed model by id.
     *
     * @param string $modelId
     * @return Model
     */
    public function findOnlyTrashedById(string $modelId): ?Model
    {
        return $this->model->findOnlyTrashedById($modelId);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model{
        return $this->model->create($payload);
    }

    /**
     * Update existing model.
     *
     * @param string $modelId
     * @param array $payload
     * @return bool
     */
    public function update(string $modelId, array $payload): bool {
        return $this->model->find($modelId)->update($payload)->fresh();
    }

    /**
     * Delete model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function deleteById(string $modelId): bool{
        return $this->model->deleteById($modelId);
    }

    /**
     * Restore model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function restoreById(string $modelId): bool{
        return $this->model->restoreById($modelId);
    }

    /**
     * Permanently delete model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function permanentlyDeleteById(string $modelId): bool {
        return $this->model->permanentlyDeleteById($modelId);
    }
}
