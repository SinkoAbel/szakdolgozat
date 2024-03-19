<?php

namespace App\Services;

use App\Models\ReservedBookings;
use App\Http\Resources\ReservedBookingsResource;

/**
 * Class ReservedBookingsService.
 */
class ReservedBookingsService extends AbstractService
{
    /**
     * Set the model of the service class.
     * 
     * @return string
     */
    protected function setModel(): string {
        return ReservedBookings::class;
    }

    /**
     * Set the Resource class of the service class.
     * 
     * @return string
     */
    protected function setResource(): string {
        return ReservedBookingsResource::class;
    }
    
    /**
     * Eager load relationship query.
     * 
     * @var array
     */
    public array $eagerLoad = [];
    
    public function __construct() {
        parent::__construct();
        $this->eagerLoad = [
            'bookable_reception_times' => function ($query) {
                $query->select(
                    'id',
                    'doctor_user_id',
                    'date',
                    'start_time',
                    'end_time',
                    'booked',
                );
            },
            'bookable_reception_times.doctor_users' => function ($query) {
                $query->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                );
            },
            'patient_users' => function ($query) {
                $query->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                );
            },
            'patient_users.patient_details' => function ($query) {
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
    
    public function getEveryBooking()
    {
        return $this->getCollection($this->eagerLoad);
    }
    
    public function getBooking(ReservedBookings $booking): ReservedBookingsResource
    {
        $booking->load($this->eagerLoad);
        return new $this->resource($booking);
    }

    public function bookAppointment(array $requestParams): ReservedBookingsResource
    {
        $createdBooking = $this->createRecord([
            'bookable_reception_times_id' => $requestParams['receptionTimeID'],
            'patient_user_id' => $requestParams['patientID'],
        ]);
        
        $createdBooking->bookable_reception_times()->update([
            'booked' => true
        ]);
        
        $createdBooking->load($this->eagerLoad);
        
        return new $this->resource($createdBooking);
    }
}
