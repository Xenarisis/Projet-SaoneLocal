<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_excl_tax' => $this->total_excl_tax,
            'percentage_tax' => $this->percentage_tax,
            'payment_status' => $this->payment_status,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
