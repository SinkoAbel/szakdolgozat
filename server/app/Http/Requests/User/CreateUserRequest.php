<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        $currentDate = Carbon::now();

        $conditionalRequired = $this->method() == self::METHOD_POST ?
                                    'required|' :
                                    '';

        return [
            'first_name'        => $conditionalRequired .'string|max:60|regex:^/[a-zA-Z]+',
            'last_name'         => $conditionalRequired .'string|max:60|regex:^/[a-zA-Z]+',
            'email'             => $conditionalRequired .'email|unique:users,email',
            'birthday'          => $conditionalRequired .'date|min:'. $currentDate->subYears(100)->format('Y-m-d')
                                    .'|max:'. $currentDate->format('Y-m-d'),
            'birthplace'        => $conditionalRequired .'string|max:80|regex:^/[a-zA-Z]+',
            'city'              => $conditionalRequired .'string|max:80|regex:^/[a-zA-Z]+',
            'zip'               => $conditionalRequired .'string|max:10',
            'street'            => $conditionalRequired .'string|max:50',
            'house_number'      => $conditionalRequired .'string|max:10',
            'insurance_number'  => $conditionalRequired .'string|max:15',
            'phone'             => $conditionalRequired .'string|max:30',
            'password'          => $conditionalRequired .'string|max:150'
        ];
    }
}
