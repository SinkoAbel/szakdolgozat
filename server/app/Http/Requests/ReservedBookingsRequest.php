<?php

namespace App\Http\Requests;

class ReservedBookingsRequest extends AbstractRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bookable_reception_times_id' => [
                $this->isRequired([self::METHOD_POST]),
                'numeric',
                'exists:bookable_reception_times,id',
            ],
            'patient_user_id' => [
                $this->isRequired([self::METHOD_POST]),
                'numeric',
                'exists:users,id'
            ],
            'filters.from_today' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    public function getParams(): array
    {
        return [
            'receptionTimeID' => $this->bookable_reception_times_id,
            'patientID' => $this->patient_user_id,
        ];
    }
}
