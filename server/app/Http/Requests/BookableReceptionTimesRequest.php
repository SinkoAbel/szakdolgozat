<?php

namespace App\Http\Requests;

class BookableReceptionTimesRequest extends AbstractRequest
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
            'doctor_user_id' => [
                $this->isRequired([self::METHOD_POST]),
                'numeric',
                'exists:users,id',
                'exists:model_has_roles,model_id,role_id,2',
            ],
            'date' => [
                $this->isRequired([self::METHOD_POST]),
                'date_format:Y-m-d'
            ],
            'start_time' => [
                $this->isRequired([self::METHOD_POST]),
                'date_format:H:i'
            ],
            'end_time' => [
                $this->isRequired([self::METHOD_POST]),
                'date_format:H:i',
                'after:start_time'
            ],
            'filters.booked' => [
                'nullable',
                'boolean'
            ],
            'filters.doctor' => [
                'nullable',
                'numeric',
                'exists:users,id',
                'exists:model_has_roles,model_id,role_id,2',
            ]
        ];
    }

    public function getParams(): array
    {
        return [
            'doctor_user_id' => $this->doctor_user_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }

    /**
     * Generate body parameters for Scribe.
     *
     * @return array
     */
    public function bodyParameters(): array
    {
        return [
            'doctor_user_id' => [
                'description' => 'Doctor user\s id.',
                'example' => '5'
            ],
            'date' => [
                'description' => 'Date of the reception time.',
                'example' => '2024-05-04'
            ],
            'start_time' => [
                'description' => 'Start time of the appointment.',
                'example' => '10:00'
            ],
            'end_time' => [
                'description' => 'End time of the reception.',
                'example' => '10:30'
            ],
        ];
    }

    /**
     * Generate query parameters for Scribe.
     *
     * @return array
     */
    public function queryParameters(): array
    {
        return [
            'filters' => [
                'booked' => [
                    'description' => 'Filter for booked or free reception times.',
                    'example' => 0
                ],
                'doctor' => [
                    'description' => 'Patient filter for specific doctor\'s appointments.',
                    'example' => 5
                ],
            ],
        ];
    }
}
