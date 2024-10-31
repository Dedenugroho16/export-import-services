<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login User
    public function login(Request $request)
{
    // Validate input
    $fields = $request->validate([
        'email' => ['required', 'max:255', 'email'],
        'password' => ['required']
    ]);

    // Check if the user exists
    $user = User::where('email', $fields['email'])->first();

    // Check if the user exists and is active
    if (!$user) {
        // User does not exist
        return back()->withErrors([
            'failed' => 'Akun yang Anda masukkan tidak ditemukan.'
        ]);
    } elseif (!$user->is_active) {
        // User is inactive
        return back()->withErrors([
            'failed' => 'Akun Anda tidak aktif.'
        ]);
    } elseif (Auth::attempt($fields, $request->remember)) {
        // Successful login
        return redirect()->intended('home');
    } else {
        // Invalid credentials
        return back()->withErrors([
            'failed' => 'Akun yang Anda masukkan tidak sesuai.'
        ]);
    }
}


    // Logout User
    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Invalidate session pengguna
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect('/');
    }
}
