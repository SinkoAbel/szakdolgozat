<?php

namespace App\Http\Requests;

use App\Http\Enums\UserRolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'email'             => [$this->isRequired(), 'email', 'unique:users,email'],
            'password'          => [$this->isRequired(), 'string', 'max:150'],
            'role'              => [
                $this->isRequired(),
                Rule::in([
                    UserRolesEnum::PATIENT,
                    UserRolesEnum::DOCTOR,
                    UserRolesEnum::ADMIN],
                )],
        ];
    }

    protected function isRequired(): string
    {
        return $this->method() == self::METHOD_POST ?
            'required' :
            '';
    }
}
