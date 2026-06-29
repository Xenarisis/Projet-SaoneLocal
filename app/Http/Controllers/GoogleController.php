<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller {
    public function redirect() {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback() {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Erreur de connexion Google']);
        }

        $user = User::where('google_token', $googleUser->getId())->first();
        $isNewUser = false;

        if (!$user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_token' => $googleUser->getId(),
                ]);
            } else {
                $isNewUser = true;
                $user = User::create([
                    'email'        => $googleUser->getEmail(),
                    'firstname'    => $googleUser->user['given_name'] ?? '',
                    'lastname'     => $googleUser->user['family_name'] ?? '',
                    'username'     => $googleUser->user['given_name'] ?? Str::random(10),
                    'password'     => Hash::make(Str::random(24)),
                    'role'         => 'google_new',
                    'google_token' => $googleUser->getId(),
                ]);
            }
        }

        $token = auth('api')->login($user);

        $isNewParam = ($user->role === 'google_new') ? '1' : '0';
        return redirect('/auth/google/success?token=' . $token . '&is_new=' . $isNewParam);
    }

    public function success(Request $request) {
        return view('auth.google-success', ['token' => $request->token]);
    }
}