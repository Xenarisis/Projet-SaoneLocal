<?php

namespace App\Policies;

use App\Models\Compose;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComposePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin() || $user->email === 'admin@admin.admin') {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Compose $compoose): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Compose $compoose): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Compose $compoose): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Compose $compoose): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Compose $compoose): bool
    {
        return false;
    }
}
