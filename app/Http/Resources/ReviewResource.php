<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id'         => $this->id,
            'rating'     => $this->rating,
            'comment'    => $this->comment,
            'product_id' => $this->product_id,
            'user_id'    => $this->user_id,
            'author'     => $this->whenLoaded('user', function () {
                return $this->user->firstname . ' ' . $this->user->lastname;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}