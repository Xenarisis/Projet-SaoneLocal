<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller {
    public function toggleBan(User $user): JsonResponse {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Action non autorisée. Vous devez être administrateur.'
            ], 403);
        }

        if (auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous bannir vous-même.'
            ], 422);
        }

        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'banni' : 'débanni';

        return response()->json([
            'success' => true,
            'message' => "L'utilisateur {$user->username} a été {$status} avec succès.",
            'data' => [
                'user_id' => $user->id,
                'username' => $user->username,
                'is_banned' => $user->is_banned
            ]
        ], 200);
    }
}
