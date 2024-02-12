<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class CreateDoctorRequest extends FormRequest
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
            'first_name' => 'required|string|max:60|regex:^/[a-zA-Z]+',
            'last_name' => 'required|string|max:60|regex:^/[a-zA-Z]+',
            'email' => 'required|email|unique:doctors,email',
            'password' => 'required|string'
        ];
    }
}
