<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    // Menampilkan data pengguna
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::query())
                ->addColumn('created_at', function (User $user) {
                    return $user->created_at->format('d M Y');
                })
                ->make(true);
        }
        return view('data-user.index');
    }
}
