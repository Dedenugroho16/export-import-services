<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Consignee;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consignees = Consignee::all();
        $clients = Client::all();
        return view('transaction.create', compact('consignees', 'clients'));
    }

    // method get Consignee
    public function getConsignees($clientId)
    {
        // Ambil consignee berdasarkan client_id
        $consignees = Consignee::where('id_client', $clientId)->pluck('name', 'id');

        // Kembalikan response dalam bentuk JSON
        return response()->json($consignees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
