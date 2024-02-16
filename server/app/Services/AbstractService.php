<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    protected function getCollection(): Collection
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

    protected function updateRecord(Model|array $updatedRecord): Model
    {
        return new $this->resource(
            $this->model::update($updatedRecord)
        );
    }

    protected function deleteRecord(Model|int $deletableRecord): bool
    {
        return $this->model::delete($deletableRecord);
    }
}
