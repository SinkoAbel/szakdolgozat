<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AbstractService.
 */
abstract class AbstractService
{
    protected string $model;
    protected string $resource;

    public function __construct()
    {
        $this->model = $this->setModel();
        $this->resource = $this->setResource();
    }

    /**
     * Set the Model of the current class.
     *
     * @return string
     */
    protected abstract function setModel(): string;

    /**
     * Set the Resource of the current class.
     *
     * @return string
     */
    protected abstract function setResource(): string;

    /**
     * Get the collection of the current class.
     * Provide eager load and scopes if needed.
     *
     * @param array $eagerLoad
     * @param array $scopes
     * @return AnonymousResourceCollection
     */
    protected function getCollection(array $eagerLoad = [], array $scopes = []): AnonymousResourceCollection
    {
        $modelQuery = $this->model::query();

        if ($eagerLoad) {
            $modelQuery->with($eagerLoad);
        }

        if ($scopes) {
            $this->getScopes($modelQuery, $scopes);
        }

        return $this->resource::collection(
            $modelQuery->get()
        );
    }

    /**
     * Get the Resource of the selected Model.
     *
     * @param Model|int $record
     * @return JsonResource
     */
    protected function getRecord(Model|int $record): JsonResource
    {
        $foundRecord = null;

        if (is_int($record)) {
            $foundRecord = $this->model::findOrFail($record);
        }

        return new $this->resource(
            is_int($record) ?
                $foundRecord :
                $record
        );
    }

    /**
     * Create a record based on the
     * array provided with params.
     *
     * @param array $newRecord
     * @return Model
     */
    protected function createRecord(array $newRecord): Model
    {
        return $this->model::create($newRecord);
    }

    /**
     * Create a User record.
     * Should provide params and role.
     *
     * @param array $newRecord
     * @param string $role
     * @return Model
     */
    protected function createUserRecord(array $newRecord, string $role): Model
    {
        $user = $this->model::create($newRecord);
        $user->assignRole($role);

        return $user;
    }

    /**
     * Update a record.
     *
     * @param Model $model
     * @param array $dataSet
     * @return JsonResource
     */
    protected function updateRecord(Model $model, array $dataSet): JsonResource
    {
        $model->update($dataSet);

        return new $this->resource($model);
    }

    /**
     * Delete the given record.
     *
     * @param Model $deletableRecord
     * @return bool
     */
    protected function deleteRecord(Model $deletableRecord): bool
    {
        return $deletableRecord->delete();
    }

    /**
     * Apply the Scopes on your query.
     *
     * @param Builder $query
     * @param array $scopes
     * @return Builder
     */
    private function getScopes(Builder $query, array $scopes)
    {
        foreach ($scopes as $scope => $parameter) {
            $query->$scope($parameter);
        }

        return $query;
    }
}
