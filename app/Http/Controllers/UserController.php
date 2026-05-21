<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function getAll() {
        return User::all();
    }

    public function getUserWithId($id) {
        return User::find($id);
    }

    public function getUserWithEmail($email) {
        return User::where('email', $email)->first();
    }
}
