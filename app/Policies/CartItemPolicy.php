<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CartItemPolicy {
    private function myCart(User $user, CartItem $cartItem) {
        return $user->id === $cartItem->user_id;
    }

    public function viewUserCartItems(User $currentUser, User $targetUser): Response {
        return $currentUser->id === $targetUser->id ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez voir que votre panier.');
    }

    public function viewProducerCartItems(User $currentUser, Product $product): Response {
        return $currentUser->id === $product->producer->user_id ? Response::allow() : Response::deny('Accès refusé. Seul le producteur peut voir les paniers.');
    } 

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CartItem $cartItem): bool {
        return $this->myCart($user, $cartItem);
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
    public function update(User $user, CartItem $cartItem): bool {
        return $this->myCart($user, $cartItem);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CartItem $cartItem): bool {
        return $this->myCart($user, $cartItem);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CartItem $cartItem): bool {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CartItem $cartItem): bool {
        return false;
    }
}
