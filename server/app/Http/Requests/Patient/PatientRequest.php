<?php

namespace App\Http\Requests\Patient;


use App\Http\Requests\UserRequest;

class PatientRequest extends UserRequest
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
        return array_merge(
        parent::rules(),
        [
            'birthday'          => [$this->isRequired(), 'date_format:Y-m-d'],
            'birthplace'        => [$this->isRequired(), 'string', 'max:80', 'regex:/^[a-zA-Z]+/'],
            'city'              => [$this->isRequired(), 'string', 'max:80', 'regex:/^[a-zA-Z]+/'],
            'zip'               => [$this->isRequired(), 'string', 'max:10'],
            'street'            => [$this->isRequired(), 'string', 'max:50'],
            'house_number'      => [$this->isRequired(), 'string', 'max:10'],
            'insurance_number'  => ['required', 'string', 'max:15'],
            'phone'             => [$this->isRequired(), 'string', 'max:30'],
        ]);
    }

    public function getParams(): array
    {
        return array_merge(
            parent::getParams(),
            [
                'birthday' => $this->birthday ?? null,
                'birthplace' => $this->birthplace ?? null,
                'city' => $this->city ?? null,
                'zip' => $this->zip ?? null,
                'street' => $this->street ?? null,
                'house_number' => $this->house_number ?? null,
                'insurance_number' => $this->insurance_number ?? null,
                'phone' => $this->phone ?? null,
            ]
        );
    }
}