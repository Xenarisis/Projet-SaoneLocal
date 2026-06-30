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
        $pdpUrl = null;
        if ($this->pdp_path) {
            $currentUser = auth('api')->user();
            $targetUser = $this->resource;
            $canViewPdp = false;

            if ($currentUser) {
                if ($currentUser->isAdmin() || $currentUser->id === $targetUser->id || $targetUser->producer()->exists()) {
                    $canViewPdp = true;
                } elseif ($currentUser->producer()->exists()) {

                    $hasOrdered = \App\Models\Order::where('user_id', $targetUser->id)
                        ->whereHas('items.product.producer', function($q) use ($currentUser) {
                            $q->where('user_id', $currentUser->id);
                        })->exists();
                    if ($hasOrdered) {
                        $canViewPdp = true;
                    }
                }
            }

            if ($canViewPdp) {
                $pdpUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                    'avatar.show', 
                    now()->addHours(24), 
                    ['filename' => basename($this->pdp_path)]
                );
            }
        }

        return [
            'id'            => $this->id,
            'firstname'     => $this->firstname,
            'lastname'      => $this->lastname,
            'full_name'     => $this->firstname . ' ' . $this->lastname,
            'email'         => $this->email,
            'username'      => $this->username,
            'role'          => $this->role,
            'lastLogin'     => $this->lastLogin,
            'GoogleToken'   => $this->when(auth('api')->user()?->isAdmin(), $this->GoogleToken),
            'has_google_linked' => !is_null($this->google_token),
            'pdp'           => $pdpUrl,
            'created_at'    => $this->created_at
        ];
    }
}
