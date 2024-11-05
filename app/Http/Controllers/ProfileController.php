<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'signature' => 'nullable|image|mimes:png|max:2048',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi untuk gambar profil
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('signature')) {
            if ($user->signature_url) {
                Storage::delete('public/' . $user->signature_url);
            }

            $path = $request->file('signature')->store('signatures', 'public');
            $user->signature_url = $path;
        }

        // Menyimpan gambar profil
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture_url) {
                Storage::delete('public/' . $user->profile_picture_url);
            }

            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_url = $profilePicturePath;
        }

        $user->save();

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully.');
    }
}
