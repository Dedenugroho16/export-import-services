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
        // Validasi input
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required']
        ]);

        // Cek apakah pengguna ada dan aktif
        $user = User::where('email', $fields['email'])->first();

        // Pastikan pengguna ada dan aktif
        if ($user && $user->is_active && Auth::attempt($fields, $request->remember)) {
            return redirect()->intended('home');
        } else {
            return back()->withErrors([
                'failed' => 'Akun yang Anda masukkan tidak sesuai atau akun Anda tidak aktif.'
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
