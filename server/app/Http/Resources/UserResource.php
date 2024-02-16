<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'birthplace' => $this->birthplace,
            'city' => $this->city,
            'zip' => $this->zip,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'insurance_number' => $this->insurance_number,
            'phone' => $this->phone,
            'token' => $this->token,
        ];
    }
}
