<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan data pengguna
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::query())
                ->addColumn('password', function (User $user) {
                    return '******';
                })
                ->addColumn('created_at', function (User $user) {
                    return $user->created_at->format('d M Y');
                })
                ->addColumn('action', function (User $user) {
                    return '
                        <button class="btn btn-warning btn-sm edit-user" data-id="' . $user->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm delete-user" data-id="' . $user->id . '">Hapus</button>
                    ';
                })
                ->rawColumns(['action']) 
                ->make(true);
        }
        return view('data-user.index'); 
    }

    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);
    
        // Membuat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Mengembalikan respons sukses
        return response()->json(['success' => true, 'message' => 'User created successfully.']);
    }

    // Menampilkan form edit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id); 
        return response()->json($user); 
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Simpan perubahan

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }

    // Fungsi untuk menghapus pengguna
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'User not found.'], 404);
    }
}
