<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use Illuminate\Http\Request;

class ConsigneesController extends Controller
{
    public function index()
    {
        $consignees = Consignee::all();
        return view('consignees.index', compact('consignees'));
    }

    public function create()
    {
        return view('consignees.create');
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:15',
            'id_client' => 'required|exists:clients,id', // Pastikan client ada
        ]);

        // Simpan data ke database
        Consignee::create([
            'name' => $request->name,
            'address' => $request->address,
            'tel' => $request->tel,
            'id_client' => $request->id_client,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('consignees.index')->with('success', 'Consignee berhasil ditambahkan.');
    }
}
