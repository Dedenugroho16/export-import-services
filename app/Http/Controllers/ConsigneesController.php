<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use App\Models\Client;
use App\Helpers\IdHashHelper; // Import the IdHashHelper for encoding/decoding
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
        $clients = Client::all();
        return view('consignees.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:20',
            'id_client' => 'required|exists:clients,id',
        ]);

        Consignee::create($request->all());

        return redirect()->route('consignees.index')->with('success', 'Consignee created successfully.');
    }

    public function edit($hash)
    {
        // Decode the hash to get the consignee's ID
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::findOrFail($id);
        $clients = Client::all();
        return view('consignees.edit', compact('consignee', 'clients'));
    }

    public function update(Request $request, $hash)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:20',
            'id_client' => 'required|exists:clients,id',
        ]);

        // Decode the hash to get the consignee's ID
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::findOrFail($id);
        $consignee->update($request->all());

        return redirect()->route('consignees.index')->with('success', 'Consignee updated successfully.');
    }

    public function show($hash)
    {
        // Decode the hash to get the consignee's ID
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::with('client')->findOrFail($id);
        return view('consignees.show', compact('consignee'));
    }

    public function destroy($hash)
    {
        // Decode the hash to get the consignee's ID
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::findOrFail($id);
        $consignee->delete();

        return redirect()->route('consignees.index')->with('success', 'Consignee deleted successfully.');
    }
}
