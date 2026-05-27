<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class AuthController extends Controller {
    public function register(RegisterUserRequest $request) {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $user = User::create($validatedData);

        return (new UserResource($user))->additional([
            'message' => 'Utilisateur créé avec succès'
        ]);
    }

    public function login(LoginUserRequest $request) {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects.'
            ], 401);
        }

        $user = auth('api')->user();
        $user->lastLogin = now();
        $user->save();

        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }

    public function logout(Request $request) {
        auth('api')->logout();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ], 200);
    }

    public function refresh() {
        return response()->json([
            'message' => 'Token rafraîchi avec succès.',
            'access_token' => auth('api')->refresh(),
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }
}
