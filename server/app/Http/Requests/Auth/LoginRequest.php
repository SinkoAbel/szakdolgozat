<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;
use App\Models\User;
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
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ],
            'password' => [
                'required',
                'string',
                'max:150',
            ],
            'token_type' => [
                'required',
                Rule::in(User::$TOKEN_TYPE)
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

    /**
     * Generate data for Scribe documentation.
     *
     * @return array[]
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'User\'s e-mail address.',
                'example' => 'xy.yahoo.com',
            ],
            'password' => [
                'description' => 'User\'s password',
                'example' => 'my$ecretpassword',
            ],
            'tokenType' => [
                'description' => 'User role based token type.',
                'example' => 'Patient-Token',
            ],
        ];
    }
}
