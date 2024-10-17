<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan data pengguna
    // Menampilkan data pengguna
public function index(Request $request)
{
    if ($request->ajax()) {
        $users = User::where('id', '!=', auth()->id())->get(); // Ambil semua pengguna kecuali pengguna yang sedang login
        return DataTables::of($users)
            ->addColumn('password', function (User $user) {
                return '******'; // Menyembunyikan password
            })
            ->addColumn('created_at', function (User $user) {
                return $user->created_at->format('d M Y'); // Format tanggal
            })
            ->addColumn('role', function (User $user) {
                return $user->role; // Menampilkan role
            })
            ->addColumn('action', function (User $user) {
                return '
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item edit-user" data-id="' . $user->id . '">Edit</a>
                        <a href="#" class="dropdown-item delete-user" data-id="' . $user->id . '">Hapus</a>
                    </div>
                </div>';
            })
            ->rawColumns(['action']) 
            ->make(true);
    }
    return view('data-user.index');
}


    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required|string|max:255', // Validasi role
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Simpan role
        ]);

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|confirmed',
            'role' => 'required|string|max:255', // Validasi role
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role; // Update role

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
