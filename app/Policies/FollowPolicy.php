<?php

namespace App\Policies;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FollowPolicy {
    private function myFollow(User $user, Follow $follow) {
        return $user->id === $follow->user_id;
    }

    public function viewUserFollows(User $currentUser, User $targetUser): Response {
        return $currentUser->id === $targetUser->id ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez voir que vos propres abonnements.');
    }

    public function viewProducerFollowers(User $currentUser, Producer $producer): Response {
        return $currentUser->id === $producer->user_id ? Response::allow() : Response::deny('Accès refusé. Seul le producteur peut voir ses abonnés.');
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
    public function view(User $user, Follow $follow): Response {
        return $this->myFollow($user, $follow) ? Response::allow() : Response::deny('Accès refusé. Cet abonnement ne vous appartient pas.');
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
    public function update(User $user, Follow $follow): bool {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Follow $follow): Response {
        return $this->myFollow($user, $follow) ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez supprimer que vos propres abonnements.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Follow $follow): bool {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Follow $follow): bool {
        return false;
    }
}
