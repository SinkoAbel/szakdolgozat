<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //'id' => $this->id,
            'birthday' => $this->birthday->format('Y-m-d'),
            'birthplace' => $this->birthplace,
            'city'	=> $this->city,
            'zip' => $this->zip,
            'street' => $this->street,
            'house_number' => $this->house_number,
            'insurance_number' => $this->insurance_number,
            'phone' => $this->phone,
        ];
    }
}
