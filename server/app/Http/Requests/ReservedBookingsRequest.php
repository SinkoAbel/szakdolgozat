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
            'bookable_reception_times_id' => 'required|numeric|exists:bookable_reception_times,id',
            'patient_user_id' => 'nullable|numeric|exists:users,id'
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