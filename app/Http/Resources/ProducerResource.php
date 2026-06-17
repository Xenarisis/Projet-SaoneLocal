<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProducerResource extends JsonResource
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
            'name' => $this->name,
            'presentation' => $this->presentation,
            'street_line_1' => $this->street_line_1,
            'street_line_2' => $this->street_line_2,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_at,
            'user_id' => $this->when(auth('api')->user()->isAdmin(), $this->user_id)
        ];
    }
}
