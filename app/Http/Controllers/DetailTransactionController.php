<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaction;

class DetailTransactionController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'transaction_id' => 'required|exists:transactions,id', // Pastikan transaction_id valid
            'id_detail_product' => 'required|exists:detail_products,id', // Pastikan id_detail_product valid
            'qty' => 'required|numeric|min:1', // Pastikan qty tidak kurang dari 1
            'carton' => 'required|numeric|min:0', // Pastikan carton tidak negatif
            'inner_qty_carton' => 'required|numeric|min:0', // Pastikan inner_qty_carton tidak negatif
            'unit_price' => 'required|numeric|min:0', // Pastikan unit_price tidak negatif
            'net_weight' => 'required|numeric|min:0', // Pastikan net_weight tidak negatif
            'price_amount' => 'required|numeric|min:0', // Pastikan price_amount tidak negatif
        ]);

        // Simpan data detail transaksi ke database
        $detailTransaction = DetailTransaction::create($validatedData);

        return response()->json(['message' => 'Detail transaction saved successfully.']);
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
