<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClientsController extends Controller
{
    public function index()
    {
        $clients = Clients::all(); // Ambil semua data klien
        return view('clients.index', compact('clients')); // Kirim data ke view
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'PO_BOX' => 'nullable|string',
            'tel' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        Clients::create($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show($id)
    {
        $client = Clients::findOrFail($id); // Temukan klien berdasarkan ID
        return view('clients.show', compact('client')); // Kirim data ke view
    }

    public function edit($id)
    {
        $client = Clients::findOrFail($id); // Temukan klien berdasarkan ID
        return view('clients.edit', compact('client')); // Kirim data ke view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'PO_BOX' => 'nullable|string',
            'tel' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        $client = Clients::findOrFail($id);
        $client->update($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client = Clients::findOrFail($id);
        $client->delete();

        // Reset auto-increment
        DB::statement('ALTER TABLE clients AUTO_INCREMENT = 1');

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
