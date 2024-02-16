<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    protected function getRecord(Model|int $record): Model
    {
        return new $this->resource(
            $this->model::findOrFail($record)
        );
    }

    protected function createRecord(array $newRecord): Model
    {
        return new $this->resource(
            $this->model::create($newRecord)
        );
    }

    protected function updateRecord(Model $model, Request $dataSet): Model
    {
        return new $this->resource(
            $model->update($dataSet->all())
        );
    }

    protected function deleteRecord(Model $deletableRecord): bool
    {
        return $this->model::delete($deletableRecord);
    }
}
