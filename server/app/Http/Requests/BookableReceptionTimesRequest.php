<?php

namespace App\Http\Requests;

use Carbon\Carbon;

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
}
