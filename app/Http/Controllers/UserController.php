<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        return getAll();
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

        $user = new User();

        $user->email = $validatedData['email'];
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];

        $user->username = $request->input('username');
        $user->GoogleToken = $request->input('GoogleToken');

        $user->password = Hash::make($validatedData['password']);
        
        $user->save();

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }

    // Read
    public function getAll() {
        return User::all();
    }

    public function getUserWithId($id) {
        return User::find($id);
    }

    public function getUserWithEmail($email) {
        return User::where('email', $email)->first();
    }

    public function getUserWithGoogleToken($GoogleToken) {
        return User::where('GoogleToken', $GoogleToken)->first();
    }

    public function getUserWithUsername($username) {
        return User::where('username', $username)->first();
    }

    // Update

    // Delete
}
