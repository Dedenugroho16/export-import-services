<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use App\Models\Client; // Mengimpor model Client untuk digunakan
use Illuminate\Http\Request;

class ConsigneesController extends Controller
{
    // Method index untuk menampilkan list consignees
    public function index()
    {
        $consignees = Consignee::all();
        return view('consignees.index', compact('consignees'));
    }

    // Method create untuk menampilkan form create
    public function create()
    {
        // Ambil semua data clients untuk ditampilkan di dropdown
        $clients = Client::all();
        return view('consignees.create', compact('clients'));
    }

    // Method store untuk menyimpan consignee baru
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:20',
            'id_client' => 'required|exists:clients,id',
        ]);

        // Simpan consignee baru
        Consignee::create([
            'name' => $request->name,
            'address' => $request->address,
            'tel' => $request->tel,
            'id_client' => $request->id_client,
        ]);

        return redirect()->route('consignees.index')->with('success', 'Consignee created successfully.');
    }

    // Method edit untuk menampilkan form edit
    public function edit($id)
    {
        $consignee = Consignee::findOrFail($id);
        $clients = Client::all(); // Ambil data clients untuk dropdown di form edit
        return view('consignees.edit', compact('consignee', 'clients'));
    }

    // Method update untuk mengupdate consignee yang ada
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:20',
            'id_client' => 'required|exists:clients,id', 
        ]);

        // Temukan consignee berdasarkan ID
        $consignee = Consignee::findOrFail($id);

        // Update consignee
        $consignee->update([
            'name' => $request->name,
            'address' => $request->address,
            'tel' => $request->tel,
            'id_client' => $request->id_client,
        ]);

        return redirect()->route('consignees.index')->with('success', 'Consignee updated successfully.');
    }

    public function show($id)
    {
        $consignee = Consignee::with('client')->findOrFail($id);
        return view('consignees.show', compact('consignee'));
    }


    // Method destroy untuk menghapus consignee
    public function destroy($id)
    {
        $consignee = Consignee::findOrFail($id);
        $consignee->delete();

        return redirect()->route('consignees.index')->with('success', 'Consignee deleted successfully.');
    }
}
