<?php

namespace App\Http\Requests;

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

        return [
            'first_name'        => 'required|string|max:60|regex:^/[a-zA-Z]+',
            'last_name'         => 'required|string|max:60|regex:^/[a-zA-Z]+',
            'email'             => 'required|email|unique:users,email',
            'birthday'          => 'required|date|min:'. $currentDate->subYears(100)->format('Y-m-d')
                                    .'|max:'. $currentDate->format('Y-m-d'),
            'birthplace'        => 'required|string|max:80|regex:^/[a-zA-Z]+',
            'city'              => 'required|string|max:80|regex:^/[a-zA-Z]+',
            'zip'               => 'required|string|max:10',
            'street'            => 'required|string|max:50',
            'house_number'      => 'required|string|max:10',
            'insurance_number'  => 'required|string|max:15',
            'phone'             => 'required|string|max:30',
            'password'          => 'required|string|max:150'
        ];
    }
}
