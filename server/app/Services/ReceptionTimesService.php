<?php

namespace App\Services;

use App\Http\Resources\BookableReceptionResource;
use App\Models\BookableReceptionTimes;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function getEveryAppointments(): AnonymousResourceCollection
    {
        return $this->getCollection($this->eagerLoad);
    }

    public function getAppointment(BookableReceptionTimes $receptionTime): BookableReceptionResource
    {
        return new $this->resource(
            $receptionTime->load($this->eagerLoad)
        );
    }

    public function createNewAppointment(array $params): BookableReceptionResource
    {
        $createdAppointment = $this->createRecord($params);
        $createdAppointment->load($this->eagerLoad);

        return new $this->resource($createdAppointment);
    }

    public function modifyAppointment(BookableReceptionTimes $receptionTimes, array $requestParams): BookableReceptionResource
    {
        // TODO: implement function
        // TODO: if patient booked Doctor can't modify appointment
    }

    public function deleteAppointment(BookableReceptionTimes $receptionTime): bool|array
    {
        // TODO: if a Patient booked Doctor can't delete appointment
        if ($receptionTime->booked) {
            return [
                'success' => false,
                'message' => 'You can\'t delete this appointment, because it is booked. Please contact administrator.',
            ];
        }
        return $this->deleteRecord($receptionTime);
    }
}
