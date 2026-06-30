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

        if ($request->hasFile('pdp')) {
            $path = $request->file('pdp')->store('avatars', 'local');
            $validatedData['pdp_path'] = basename($path);
        }

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
            $user = User::where('email', $request->email)->first();
            if ($user && $user->google_token) {
                return response()->json([
                    'message' => 'Identifiants incorrects. Note : Ce compte est lié à Google, essayez de vous connecter via le bouton Google ou de définir un mot de passe dans votre profil.'
                ], 401);
            }

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

    public function me(): UserResource {
        return new UserResource(auth('api')->user());
    }

    public function completeProfile(Request $request) {
        $user = auth('api')->user();

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $user->id,
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->username = $request->username;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        if ($user->role === 'google_new') {
            $user->role = 'user';
        }

        $user->save();

        $newToken = auth('api')->login($user);

        return response()->json([
            'message' => 'Profil complété avec succès !',
            'data' => $user,
            'token' => $newToken
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
