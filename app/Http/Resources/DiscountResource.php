<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id'                => $this->id,
            'discount_percent'  => $this->discount_percent,
            'code_name'         => $this->code_name,
            'availibility'      => $this->availibility,
            'max_use'           => $this->max_use,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}