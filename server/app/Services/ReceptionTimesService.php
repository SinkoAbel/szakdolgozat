<?php

namespace App\Services;

use App\Http\Resources\BookableReceptionResource;
use App\Models\BookableReceptionTimes;

/**
 * Class ReceptionTimesService.
 */
class ReceptionTimesService extends AbstractService
{
    protected function setModel(): string
    {
        return BookableReceptionTimes::class;
    }

    protected function setResource(): string
    {
        return BookableReceptionResource::class;
    }

    /**
     * Eager load queries.
     *
     * @var array
     */
    public array $eagerLoad = [];

    public function __construct()
    {
        parent::__construct();
        $this->eagerLoad = [
            'doctor_users' => function ($query) {
                $query->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email'
                );
            }
        ];
    }

    public function createNewAppointment(array $params): BookableReceptionResource
    {
        $createdAppointment = $this->createRecord($params);
        $createdAppointment->load($this->eagerLoad);

        return new $this->resource($createdAppointment);
    }
}