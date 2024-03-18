<?php

namespace App\Http\Requests;

use App\Http\Interfaces\IHttpDependableRequired;
use App\Http\Interfaces\IReturnableParams;
use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest implements IHttpDependableRequired, IReturnableParams
{
    /**
     * Determine if the user is authorized to make this request.
     */
    abstract function authorize(): bool;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    abstract function rules(): array;

    /**
     * If the HTTP method is POST it makes the field required.
     * Otherwise, it's optional.
     *
     * @param array $methods
     * @return string
     */
    public function isRequired(array $methods): string
    {
        return in_array($this->method(), $methods) ?
        'required' :
        'nullable';
    }

    public function isUnique(string $table, string $field, array $methods): string
    {
        return in_array($this->method(), $methods) ?
            "unique:$table,$field" :
            "";
    }
}
