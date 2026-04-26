<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Demo: accept any credentials and redirect to dashboard
        // In production: if (Auth::attempt($credentials, $request->boolean('remember'))) { ... }
        return redirect()->route('dashboard');
    }

    public function logout()
    {
        // Auth::logout();
        return redirect()->route('login');
    }
}
