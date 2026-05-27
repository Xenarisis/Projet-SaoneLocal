<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\PutUserRequest;
use App\Http\Requests\PatchUserRequest;
use App\Http\Requests\DeleteUserRequest;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {
    // Create : view AuthController

    // Read
    public function getAll() {
        Gate::authorize('viewAny', User::class);

        $users = User::paginate(50);
        return UserResource::collection($users);
    }

    public function getUserById(GetUserRequest $request, User $user) {
        // Query string And Form Request
        // Gate::authorize('view', $user);
        $validatedData = $request->validated();

        return new UserResource($user);
    }

    public function getUserByEmail($email) {
        $userModel = User::where('email', $email)->firstOrFail();

        Gate::authorize('view', $userModel);

        return new UserResource($userModel);
    }

    public function getUserByGoogleToken($token) {
        $userModel = User::where('GoogleToken', $token)->firstOrFail();

        Gate::authorize('view', $userModel);

        return new UserResource($userModel);
    }

    public function getUserByUsername($username) {
        $userModel = User::where('username', $username)->firstOrFail();

        Gate::authorize('view', $userModel);

        return new UserResource($userModel);
    }

    // Put
    public function putUser(PutUserRequest $request, User $user) {
        $validatedData = $request->validated();

        if($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return (new UserResource($user))->additional([
            'message' => 'Utilisateur mis à jour avec succès'
        ]);
    }

    // Patch
    public function patchUser(PatchUserRequest $request, User $user) {
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
    public function deleteUser(DeleteUserRequest $request, User $user) {
        if(auth('api')->id() === $user->id) {
            if($request->filled('GoogleToken')) {
                if ($user->GoogleToken === null || $request->GoogleToken !== $user->GoogleToken) {
                    return response()->json([
                        'message' => 'Action non autorisée. Token Google invalide.'
                    ], 403);
                }
            }
        }

        $user->delete();

        return response()->json([
            'message' => 'Utilisateur supprimé avec succès'
        ], 200);
    }
}
