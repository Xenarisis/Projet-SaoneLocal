<?php

namespace App\Policies;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FollowPolicy {
    public function before(User $user, string $ability): ?bool {
        if ($user->isAdmin()) {
            return true;
        }
        
        return null;
    }

    private function myFollow(User $user, Follow $follow) {
        return $user->id === $follow->user_id;
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
    public function view(User $user, Follow $follow): bool {
        return $this->myFollow($user, $follow);
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
    public function delete(User $user, Follow $follow): bool {
        return $this->myFollow($user, $follow);
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
