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
        $validatedData = $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->lastLogin = now();

        $user->save();

        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.'
        ], 200);
    }

    public function logoutEverywhere(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion de tous les appareils réussie.'
        ], 200);
    }
}
