<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller {
    public function index() {
        return $this->getAll();
    }

    // Other
    public function loginUser(Request $request) {
        $request->validate([
            'email' => 'required|email',
            // No 'min' validation here: increasing it in the future would lock out legacy users.
            'password' => 'required|string|max:255'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Les identifiants sont incorrects.'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    // Create
    public function createUser(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'firstname' => 'required|string|min:1|max:20',
            'lastname' => 'required|string|min:1|max:20',
            'username' => 'nullable|string|unique:users|min:1|max:25',
            'GoogleToken' => 'nullable|string|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $user = User::create($validatedData);

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }

    // Read
    public function getAll() {
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Accès refusé. Espace réserver aux administrateurs.'
            ], 403);
        }

        return User::all();
    }

    public function getUserWithId($id) {
        if(auth()->id() != $id && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour récupérer un autre compte que le vôtre.'
            ], 403);
        }

        return User::findOrFail($id);
    }

    public function getUserWithEmail($email) {
        if(auth()->user()->email != $email && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour récupérer un autre compte que le vôtre.'
            ], 403);
        }

        return User::where('email', $email)->firstOrFail();
    }

    public function getUserWithGoogleToken($GoogleToken) {
        if(auth()->user()->GoogleToken != $GoogleToken && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour récupérer un autre compte que le vôtre.'
            ], 403);
        }

        return User::where('GoogleToken', $GoogleToken)->firstOrFail();
    }

    public function getUserWithUsername($username) {
        if(auth()->user()->username != $username && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour récupérer un autre compte que le vôtre.'
            ], 403);
        }

        return User::where('username', $username)->firstOrFail();
    }

    // Put
    public function putUser(Request $request, $id) {
        $user = User::findOrFail($id);

        if(auth()->id() != $id && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour mettre à jour un autre compte que le vôtre.'
            ], 403);
        }

        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'firstname' => 'required|string|min:1|max:20',
            'lastname' => 'required|string|min:1|max:20',
            'username' => 'nullable|string|unique:users|min:1|max:25|unique:users,username,' . $user->id,
            'GoogleToken' => 'nullable|string|unique:users,GoogleToken,' . $user->id,
            'password' => 'sometimes|string|min:6|max:50'
        ]);

        if($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user' => $user
        ], 200);
    }

    // (Patch)
    public function patchUser(Request $request, $id) {
        $user = User::findOrFail($id);

        if(auth()->id() != $id && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour mettre à jour un autre compte que le vôtre.'
            ], 403);
        }

        $validatedData = $request->validate([
            'email'       => 'sometimes|required|email|unique:users,email,' . $user->id,
            'firstname'   => 'sometimes|required|string|min:1|max:20',
            'lastname'    => 'sometimes|required|string|min:1|max:20',
            'username'    => 'sometimes|nullable|string|min:1|max:25|unique:users,username,' . $user->id,
            'GoogleToken' => 'sometimes|nullable|string|unique:users,GoogleToken,' . $user->id,
            'password'    => 'sometimes|required|string|min:6|max:50'
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user' => $user
        ], 200);
    }

    // Delete
    public function deleteUser(Request $request, $id) {
        $user = User::findOrFail($id);

        if (auth()->id() != $id && auth()->user()->role !== 'admin') {
            return response()->json([
                'message' => 'Action non autorisée. Vous n\'avez pas les droits nécessaires pour supprimer un autre compte que le vôtre.'
            ], 403);
        }

        if ($request->has('GoogleToken')) {
            if ($user->GoogleToken === null || $request->GoogleToken !== $user->GoogleToken) {
                return response()->json([
                    'message' => 'Action non autorisée. Token Google invalide.'
                ], 401);
            }
        } else {
            $request->validate([
                'password' => 'required|string|max:255'
            ]);

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Mot de passe incorrect. Suppression refusée.'
                ], 403);
            }
        }

        $user->delete();

        return response()->json([
            'message' => 'Utilisateur supprimé avec succès'
        ], 200); 
    }
}
