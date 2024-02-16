<?php

namespace App\Services;

use App\Http\Resources\RouteResource;
use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RouteService.
 */
class RouteService extends AbstractService
{
    protected function setModel(): string
    {
        return Route::class;
    }

    protected function setResource(): string
    {
        return RouteResource::class;
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function getRoutes(): Collection
    {
        return $this->getCollection();
    }
}
