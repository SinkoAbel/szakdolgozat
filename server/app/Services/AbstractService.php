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

    protected function setModel(string $model): void
    {
        $this->model = $model;
    }

    protected function getCollection(): Collection
    {
        return $this->model::all();
    }

    protected function getRecord(Model|int $record): Model
    {
        return $this->model::find($record);
    }

    protected function createRecord(array $newRecord): Model
    {
        return $this->model::create($newRecord);
    }

    protected function updateRecord(Model|array $updatedRecord): Model
    {
        return $this->model::update($updatedRecord);
    }

    protected function deleteRecord(Model|int $deletableRecord): bool
    {
        return $this->model::delete($deletableRecord);
    }
}
