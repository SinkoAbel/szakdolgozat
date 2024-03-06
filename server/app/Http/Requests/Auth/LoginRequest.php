<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends AbstractRequest
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
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'max:150',
            ],
            'tokenType' => [
                'required',
                Rule::in(['Patient-Token', 'Doctor-Token', 'Admin-Token'])
            ]
        ];
    }

    /**
     * Get the params from the request.
     *  
     * @return array<string, string>
     */
    public function getParams(): array
    {
        return [
            'email'=> $this->email,
            'password'=> $this->password,
            'tokenType' => $this->tokenType,
        ];
    }
}
