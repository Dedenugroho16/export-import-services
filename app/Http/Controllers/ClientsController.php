<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Helpers\IdHashHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Clients::all();
        return view('clients.index', compact('clients'));
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

        return redirect()->route('clients.index')->with('success', 'Data client berhasil ditambahkan.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'PO_BOX' => 'nullable|string',
            'tel' => 'required|string|max:20',
            'fax' => 'nullable|string|max:20',
        ]);

        $client = Clients::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Data client berhasil di update.');
    }

    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $client = Clients::findOrFail($id);
        $client->delete();

        DB::statement('ALTER TABLE clients AUTO_INCREMENT = 1');

        return redirect()->route('clients.index')->with('success', 'Data clien berhasil di hapus.');
    }
}
