<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            if (Auth::user()->is_active) {
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'failed' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator untuk informasi lebih lanjut.',
                ]);
            }
        }

        return back()->withErrors([
            'failed' => 'Login tidak berhasil. Silakan periksa kembali username/email dan password Anda.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
