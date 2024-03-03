<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'first_name'        => 'required|string|max:60|regex:/^[a-zA-Z]+/',
            'last_name'         => 'required|string|max:60|regex:/^[a-zA-Z]+/',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|max:150',
            'role'              => ['required', Rule::in(['patient', 'doctor', 'admin'])]
        ];
    }
}
