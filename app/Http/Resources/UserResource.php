<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'full_name' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->role,
            'lastLogin' => $this->lastLogin,
            'GoogleToken' => $this->when(auth('api')->user()->isAdmin(), $this->GoogleToken),
            'created_at' => $this->created_at
        ];
    }
}
