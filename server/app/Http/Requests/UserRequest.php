<?php

namespace App\Http\Requests;

use App\Http\Enums\UserRolesEnum;
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
            'first_name'        => [$this->isRequired(), 'string', 'max:60', 'regex:/^[a-zA-Z]+/'],
            'last_name'         => [$this->isRequired(), 'string', 'max:60', 'regex:/^[a-zA-Z]+/'],
            'email'             => [$this->isRequired(), 'email', $this->uniqueOnPost('users', 'email')],
            'password'          => [$this->isRequired(), 'string', 'max:150'],
            'role'              => [
                $this->isRequired(),
                Rule::in([
                    UserRolesEnum::PATIENT,
                    UserRolesEnum::DOCTOR,
                    UserRolesEnum::ADMIN,
                ])
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

    protected function uniqueOnPost(string $table, string $field): string
    {
        return $this->method() == self::METHOD_POST ?
                    "unique:$table,$field" :
                    "";
    }
}
