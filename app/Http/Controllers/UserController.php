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
            ->addColumn('status', function (User $user) {
                return $user->is_active ? 'Aktif' : 'Tidak Aktif'; // Menampilkan status
            })
            ->addColumn('action', function (User $user) {
                $activeIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-circle me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3v0a9 9 0 1 0 9 9a9 9 0 0 0 -9 -9z" /></svg>'; // Icon untuk aktif
                $inactiveIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-circle me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3v0a9 9 0 1 0 9 9a9 9 0 0 0 -9 -9z" /></svg>'; // Icon untuk tidak aktif

                return '
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item edit-user" data-id="' . $user->id . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                        </a>
                        <a href="#" class="dropdown-item toggle-active" data-id="' . $user->id . '" data-status="' . $user->is_active . '">
                            ' . ($user->is_active ? $inactiveIcon . ' Nonaktifkan' : $activeIcon . ' Aktifkan') . '
                        </a>
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
            'role' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true, // Set akun baru aktif secara default
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
            'role' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'User updated successfully.']);
    }

    // Mengaktifkan atau menonaktifkan akun pengguna
    public function toggleActive(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active; // Toggle status
        $user->save();

        return response()->json(['success' => true, 'message' => 'User status updated successfully.']);
    }
}
