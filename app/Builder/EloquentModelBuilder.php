<?php
namespace App\Builder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EloquentModelBuilder extends Builder {
 
    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed() : Collection {
        return $this->onlyTrashed();
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
        string $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ? Model {
        
        return $this->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param string $modelId
     * @return Model
     */
    public function findTrashedById(string $modelId): ?Model{
        return $this->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id.
     *
     * @param string $modelId
     * @return Model
     */
    public function findOnlyTrashedById(string $modelId): ?Model{
        return $this->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Delete model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function deleteById(string $modelId): bool{
        return $this->findById($modelId)->delete();
    }

    /**
     * Restore model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function restoreById(string $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id.
     *
     * @param string $modelId
     * @return bool
     */
    public function permanentlyDeleteById(string $modelId): bool{
        return $this->findTrashedById($modelId)->forceDelete();
    }


    public function customWhere( Array $params = []){


        foreach ($params as $key => $value) {
            $this->when( is_array($value),
            fn($query) => $query->whereIn($key, $value),
            fn($query) => $query->where($key, $value));
        }

    return $this;
    }
}