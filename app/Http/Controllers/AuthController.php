<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller {
    public function register(RegisterUserRequest $request): UserResource {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $user = User::create($validatedData);

        $user->last_login = now();
        $user->role = 'user';
        $user->save();

        $token = auth('api')->login($user);

        return (new UserResource($user))->additional([
            'access_token'  => $token,
            'message'       => 'Utilisateur créé avec succès'
        ]);
    }

    public function login(LoginUserRequest $request): JsonResponse {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects.'
            ], 401);
        }

        $user = auth('api')->user();
        $user->last_login = now();
        $user->save();

        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }

    public function logout(Request $request): JsonResponse {
        auth('api')->logout();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ], 200);
    }

    public function refresh(): JsonResponse {
        return response()->json([
            'message' => 'Token rafraîchi avec succès.',
            'access_token' => auth('api')->refresh(),
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }
}
