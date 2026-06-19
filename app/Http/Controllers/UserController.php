<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\PutUserRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\PatchUserRequest;
use App\Http\Requests\DeleteUserRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller {
    // Read
    public function index(GetUserRequest $request): AnonymousResourceCollection {
        $query = User::query();

        $currentUser = $request->user();
        
        if ($currentUser && !$currentUser->isAdmin()) {
            $query->where('id', $currentUser->id);
        }

        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        }

        if ($request->filled('email')) {
            $query->where('email', $request->input('email'));
        }

        if ($request->filled('username')) {
            $query->where('username', $request->input('username'));
        }

        if ($request->filled('google_token')) {
            $query->where('google_token', $request->input('google_token'));
        }

        $users = $query->paginate(50);
        $users->appends($request->all());

        return UserResource::collection($users);
    }

    public function show(ShowUserRequest $request, User $user): UserResource {
        return new UserResource($user);
    }

    // Update : Put
    public function updatePut(PutUserRequest $request, User $user): UserResource {
        $validatedData = $request->validated();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return (new UserResource($user))->additional([
            'message' => 'Utilisateur mis à jour avec succès.'
        ]);
    }

    // Update : Patch
    public function updatePatch(PatchUserRequest $request, User $user): UserResource {
        $validatedData = $request->validated();

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return (new UserResource($user))->additional([
            'message' => 'Utilisateur mis à jour avec succès.'
        ]);
    }

    // Delete
    public function destroy(DeleteUserRequest $request, User $user): JsonResponse {
        $currentUser = $request->user();

        $isAdmin = $currentUser->isAdmin();
        $isOwner = $currentUser->id === $user->id;

        if (!$isAdmin && !$isOwner) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($isOwner && !$isAdmin) {
            if ($request->filled('google_token')) {
                if ($user->google_token === null || $request->input('google_token') !== $user->google_token) {
                    return response()->json(['message' => 'Action non autorisée. Token Google invalide.'], 403);
                }
            }
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès.'], 200);
    }
}