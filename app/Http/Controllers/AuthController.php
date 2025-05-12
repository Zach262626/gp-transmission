<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate( [
            "email"=> ['required', 'max:255', 'email'],
            "password"=> ['required', 'max:255']
        ]);
    }
    public function register(Request $request) {
        $fields = $request->validate( [
            "email"=> ['required', 'max:255', 'email'],
            "password"=> ['required', 'max:255', 'min:8']
        ]);
        $user = User::create( $fields );
        Auth::login($user);
        return redirect()->route('main');
    }
}
