<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\Response;

class ReviewPolicy {
    public function before(User $user, string $ability): ?bool {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    private function isMyReview(User $user, Review $review): bool {
        return $user->id === $review->user_id;
    }

    public function viewAny(User $user): bool {
        return true;
    }

    public function view(User $user, Review $review): bool {
        return true;
    }

    public function create(User $user): bool {
        return true;
    }

    public function update(User $user, Review $review): Response {
        return $this->isMyReview($user, $review) ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez modifier que vos propres avis.');
    }

    public function delete(User $user, Review $review): Response {
        return $this->isMyReview($user, $review) ? Response::allow() : Response::deny('Accès refusé. Vous ne pouvez supprimer que vos propres avis.');
    }
}