<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function show()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login
        return view('profile.index', compact('user')); // Mengirim data pengguna ke view
    }

    // Memperbarui profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Update data pengguna
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika pengguna memasukkan password baru
        if ($request->password) {
            $user->password = Hash::make($request->password); // Hash password baru
        }

        // Cek jika ada file gambar yang diupload
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture_url) {
                Storage::delete('public/' . $user->profile_picture_url); // Menghapus gambar lama dari storage
            }

            // Simpan foto baru
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_url = $path; // Simpan path foto ke database
        }

        $user->save(); // Simpan perubahan

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile.show')->with('status', 'Profile updated successfully.');
    }
}
