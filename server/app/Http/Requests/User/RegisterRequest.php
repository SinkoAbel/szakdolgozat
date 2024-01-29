<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'        => 'required|string|max:50',
            'last_name'         => 'required|string|max:50',
            'email'             => 'required|email',
            'password'          => 'required|string|min:5|max:40',
            'birthdate'         => 'required|date_format:Y-m-d',
            'insurance_number'  => 'required|string|max:9',
            'zip'               => 'required|string|max:4',
            'living_city'       => 'required|string',
            'street'            => 'required|string',
            'house_number'      => 'required|string'
        ];
    }
}
