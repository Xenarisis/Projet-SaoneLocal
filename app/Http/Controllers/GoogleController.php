<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller {
    public function redirect(Request $request) {
        $driver = Socialite::driver('google')->stateless();

        $params = ['hl' => 'fr']; 
        if ($request->has('token')) {
            $params['state'] = $request->token;
        }

        return $driver->with($params)->redirect();
    }

    public function callback(Request $request) {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Erreur de connexion Google']);
        }

        $token = $request->input('state');
        if ($token) {
            $currentUser = auth('api')->setToken($token)->user();
            if ($currentUser) {
                $existing = User::where('google_token', $googleUser->getId())->first();
                if ($existing && $existing->id !== $currentUser->id) {
                    return redirect('/auth/google/success?token=' . $token . '&error=already_linked');
                }

                $currentUser->update(['google_token' => $googleUser->getId()]);
                return redirect('/auth/google/success?token=' . $token . '&linked=1');
            }
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
                $fullName = $googleUser->getName() ?: '';
                $nameParts = explode(' ', $fullName, 2);
                    $fallbackFirst = $nameParts[0] ?? '';
                    $fallbackLast = $nameParts[1] ?? '';

                    $user = User::create([
                        'email'        => $googleUser->getEmail(),
                        'firstname'    => $googleUser->user['given_name'] ?? $fallbackFirst,
                        'lastname'     => $googleUser->user['family_name'] ?? $fallbackLast,
                        'username'     => 'User_' . Str::random(5),
                    'password'     => Hash::make(Str::random(24)),
                    'role'         => 'google_new',
                    'google_token' => $googleUser->getId(),
                ]);
            }
        }
        if ($user->is_banned) {
            $user->last_login = now();
            $user->save();
            $token = auth('api')->login($user);
            return redirect('/auth/google/success?token=' . $token . '&is_banned=1');
        }
        
        $user->last_login = now();
        $user->save();

        $token = auth('api')->login($user);

        $isNewParam = ($user->role === 'google_new') ? '1' : '0';
        return redirect('/auth/google/success?token=' . $token . '&is_new=' . $isNewParam);
    }

    public function success(Request $request) {
        return view('auth.google-success', ['token' => $request->token]);
    }
}