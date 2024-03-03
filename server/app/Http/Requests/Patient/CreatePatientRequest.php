<?php

namespace App\Http\Requests\Patient;


use App\Http\Requests\CreateUserRequest;

class CreatePatientRequest extends CreateUserRequest
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
        $conditionalRequired = $this->method() == self::METHOD_POST ?
                                    'required|' :
                                    '';

        return array_merge(
        parent::rules(),
        [
            'birthday'          => $conditionalRequired .'date_format:Y-m-d',
            'birthplace'        => $conditionalRequired .'string|max:80|regex:/^[a-zA-Z]+/',
            'city'              => $conditionalRequired .'string|max:80|regex:/^[a-zA-Z]+/',
            'zip'               => $conditionalRequired .'string|max:10',
            'street'            => $conditionalRequired .'string|max:50',
            'house_number'      => $conditionalRequired .'string|max:10',
            'insurance_number'  => $conditionalRequired .'string|max:15',
            'phone'             => $conditionalRequired .'string|max:30',
        ]);
    }
}
