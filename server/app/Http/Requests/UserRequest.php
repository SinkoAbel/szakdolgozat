<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class UserRequest extends AbstractRequest
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
            'first_name' => [
                $this->isRequired([self::METHOD_POST]),
                'string',
                'max:60'
            ],
            'last_name' => [
                $this->isRequired([self::METHOD_POST]),
                'string',
                'max:60'
            ],
            'email' => [
                $this->isRequired([self::METHOD_POST]),
                'email',
                $this->isUnique('users', 'email', [self::METHOD_POST])
            ],
            'password' => [
                $this->isRequired([self::METHOD_POST]),
                'string',
                'max:150'
            ],
            'role' => [
                $this->isRequired([self::METHOD_POST]),
                Rule::in(User::$ROLES)
            ],
        ];
    }

    /**
     * Returns the parameters from the request.
     *
     * @return array<string, string|null>
     */
    public function getParams(): array
    {
        return [
            'first_name' => $this->first_name ?? null,
            'last_name' => $this->last_name ?? null,
            'email' => $this->email ?? null,
            'password'=> $this->password ?? null,
            'role'=> $this->role ?? null,
        ];
    }
}
