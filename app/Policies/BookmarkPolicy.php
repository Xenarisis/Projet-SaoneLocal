<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Auth\Access\Response;

class BookmarkPolicy {
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin() || $user->email === 'admin@admin.admin') {
            return true;
        }
        return null;
    }

    private function isMyBookmark(User $user, Bookmark $bookmark): bool {
        return $user->id === $bookmark->user_id;
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
    public function view(User $user, Bookmark $bookmark): bool {
        return $this->isMyBookmark($user, $bookmark);
    }

    /**
     * Determine whether the user can see bookmark of a specific user.
     */
    public function viewUserBookmarks(User $currentUser, User $targetUser): Response {
        return $currentUser->id === $targetUser->id ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez voir que vos propres favoris.');
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
    public function update(User $user, Bookmark $bookmark): bool {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bookmark $bookmark): Response {
        return $this->isMyBookmark($user, $bookmark) ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez supprimer que vos propres favoris.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bookmark $bookmark): bool {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bookmark $bookmark): bool {
        return false;
    }
}