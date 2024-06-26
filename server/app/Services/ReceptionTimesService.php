<?php

namespace App\Services;

use App\Http\Enums\UserRolesEnum;
use App\Http\Resources\BookableReceptionResource;
use App\Models\BookableReceptionTimes;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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

    /**
     * Extended eager load query with Patient details.
     *
     * @var array
     */
    public array $extendedEagerLoad = [];

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
        $this->extendedEagerLoad = [
            'reserved_bookings' => function ($query) {
                $query->select('*');
            },
            'reserved_bookings.patient_users' => function ($query) {
                $query->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                );
            },
            'reserved_bookings.patient_users.patient_details' => function ($query) {
                $query->select(
                    'id',
                    'user_id',
                    'birthday',
                    'birthplace',
                    'city',
                    'zip',
                    'street',
                    'house_number',
                    'insurance_number',
                    'phone'
                );
            },
        ];
    }

    public function getEveryAppointments(array $filters, string $role = 'doctor'): AnonymousResourceCollection
    {
        $scopes = null;

        if ($role == UserRolesEnum::DOCTOR->value) {
            $scopes = [
                'filterForDoctor' => $filters['doctor_id']
            ];
        }

        if ($role == UserRolesEnum::PATIENT->value) {
            $scopes = [
                'filterForDoctor' => $filters['doctor'],
                'filterBookedAppointments' => $filters['booked'],
                'filterFromToday' => true
            ];
        }

        return $this->getCollection(
            array_merge($this->eagerLoad, $this->extendedEagerLoad),
            $scopes
        );
    }

    public function getAppointment(BookableReceptionTimes $receptionTime): BookableReceptionResource
    {
        return new $this->resource(
            $receptionTime->load(
                array_merge($this->eagerLoad, $this->extendedEagerLoad)
            )
        );
    }

    public function createNewAppointment(array $params): BookableReceptionResource
    {
        $createdAppointment = $this->createRecord($params);
        $createdAppointment->load($this->eagerLoad);

        return new $this->resource($createdAppointment);
    }

    public function modifyAppointment(BookableReceptionTimes $receptionTime, array $requestParams): BookableReceptionResource|JsonResource|array
    {
        if ($receptionTime->booked) {
            return [
                'success' => false,
                'message' => 'You can\'t delete this appointment, because a patient already booked. Please contact your administrator.',
            ];
        }

        return $this->updateRecord($receptionTime, [
            'doctor_user_id' => $requestParams['doctor_user_id'] ?? $receptionTime->doctor_user_id,
            'date' => $requestParams['date'] ?? $receptionTime->date,
            'start_time' => $requestParams['start_time'] ?? $receptionTime->start_time,
            'end_time' => $requestParams['end_time'] ?? $receptionTime->end_time
        ]);
    }

    public function deleteAppointment(BookableReceptionTimes $receptionTime): bool|array
    {
        if ($receptionTime->booked) {
            return [
                'success' => false,
                'message' => 'You can\'t delete this appointment, because it is booked. Please contact administrator.',
            ];
        }
        return $this->deleteRecord($receptionTime);
    }
}
