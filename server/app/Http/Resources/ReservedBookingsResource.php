<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservedBookingsResource extends JsonResource
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
            'bookable_reception_times' => BookableReceptionResource::collection($this->whenLoaded('bookable_reception_times')),
            'patient' => $this->patient_users,
        ];
    }
}
