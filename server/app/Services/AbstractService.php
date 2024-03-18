<?php

namespace App\Services;

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

    protected abstract function setModel(): string;
    protected abstract function setResource(): string;

    protected function getCollection(): AnonymousResourceCollection
    {
        return $this->resource::collection(
            $this->model::all()
        );
    }

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

    protected function createRecord(array $newRecord): Model
    {
        return $this->model::create($newRecord);
    }

    protected function createUserRecord(array $newRecord, string $role): Model
    {
        $user = $this->model::create($newRecord);
        $user->assignRole($role);

        return $user;
    }

    protected function updateRecord(Model $model, array $dataSet): JsonResource
    {
        $model->update($dataSet);

        return new $this->resource($model);
    }

    protected function deleteRecord(Model $deletableRecord): bool
    {
        return $deletableRecord->delete();
    }
}
