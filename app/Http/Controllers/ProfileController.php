<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $user = Auth::user(); // Mengambil pengguna yang sedang login

        // Update data pengguna
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Cek jika ada file gambar yang diupload
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture_url) {
                Storage::delete($user->profile_picture_url);
            }

            // Simpan foto baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_url = $path;
        }

        $user->save();

        return redirect()->back()->with('status', 'Profil berhasil diperbarui!');
    }
}
