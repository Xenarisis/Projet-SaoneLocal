<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy {
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin() || $user->email === 'admin@admin.admin') {
            return true;
        }
        return null;
    }

    private function isProducer(User $user) {
        return $user->role === 'producer' && $user->producer()->exists();
    }

    private function ownProduct(User $user, Product $product) {
        return $user->producer->id === $product->producer_id;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Product $product): bool {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        return $this->isProducer($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool {
        return $this->isProducer($user) && $this->ownProduct($user, $product);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool {
        return $this->isProducer($user) && $this->ownProduct($user, $product);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool {
        return $this->isProducer($user) && $this->ownProduct($user, $product);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool {
        return false;
    }
}
