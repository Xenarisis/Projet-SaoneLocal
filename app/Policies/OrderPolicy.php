<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy {
    public function before(User $user, string $ability): ?bool {
        if ($user->isAdmin()) {
            return true;
        }
        
        return null;
    }

    private function ownOrder(User $user, Order $order) {
        return $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool {
        return $this->ownOrder($user, $order);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool {
        return $this->ownOrder($user, $order);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool {
        // Producer need to be able to delete product related in user order (cart items ?)
        return $this->ownOrder($user, $order);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool {
        return false;
    }
}
