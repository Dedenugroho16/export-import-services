<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
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
        $validatedData = $request->validate([
            'id_transaction' => 'required|exists:transactions,id', // Pastikan id_transaction valid
            'transactions.*.id_detail_product' => 'required|exists:detail_products,id',
            'transactions.*.qty' => 'required|numeric|min:1',
            'transactions.*.carton' => 'required|numeric|min:1',
            'transactions.*.inner_qty_carton' => 'required|numeric|min:0|max:9999999.99',
            'transactions.*.unit_price' => 'required|numeric|min:0',
            'transactions.*.net_weight' => 'required|numeric|min:0|max:9999999.99',
            'transactions.*.price_amount' => 'required|numeric|min:0',
        ]);

        foreach ($validatedData['transactions'] as $detail) {
            DetailTransaction::create([
                'id_transaction' => $validatedData['id_transaction'], // Set ID transaksi
                'id_detail_product' => $detail['id_detail_product'],
                'qty' => $detail['qty'],
                'carton' => $detail['carton'],
                'inner_qty_carton' => $detail['inner_qty_carton'],
                'unit_price' => $detail['unit_price'],
                'net_weight' => $detail['net_weight'],
                'price_amount' => $detail['price_amount'],
            ]);
        }

        return response()->json(['message' => 'Detail transactions saved successfully'], 201);
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
        // Validasi data yang dikirim
        $validatedData = $request->validate([
            'id_transaction' => 'required|exists:transactions,id', // Pastikan id_transaction valid
            'transactions.*.id' => 'required|exists:detail_transactions,id', // ID detail transaksi harus ada untuk update
            'transactions.*.id_detail_product' => 'required|exists:detail_products,id',
            'transactions.*.qty' => 'required|numeric|min:1',
            'transactions.*.carton' => 'required|numeric|min:0',
            'transactions.*.inner_qty_carton' => 'required|numeric|min:0',
            'transactions.*.unit_price' => 'required|numeric|min:0',
            'transactions.*.net_weight' => 'required|numeric|min:0',
            'transactions.*.price_amount' => 'required|numeric|min:0',
        ]);

        // Loop melalui setiap detail transaksi dan perbarui data
        foreach ($validatedData['transactions'] as $detail) {
            // Cari detail transaksi berdasarkan ID
            $detailTransaction = DetailTransaction::findOrFail($detail['id']);

            // Update detail transaksi
            $detailTransaction->update([
                'id_transaction' => $validatedData['id_transaction'], // Update ID transaksi jika diperlukan
                'id_detail_product' => $detail['id_detail_product'],
                'qty' => $detail['qty'],
                'carton' => $detail['carton'],
                'inner_qty_carton' => $detail['inner_qty_carton'],
                'unit_price' => $detail['unit_price'],
                'net_weight' => $detail['net_weight'],
                'price_amount' => $detail['price_amount'],
            ]);
        }

        // Kembalikan response JSON dengan status sukses
        return response()->json(['message' => 'Detail transactions updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_detail_transaction, $id_detail_product)
    {
        // Mencari detail transaksi yang cocok dengan kedua ID
        $detailTransaction = DetailTransaction::where('id', $id_detail_transaction)
            ->where('id_detail_product', $id_detail_product)
            ->first();

        if ($detailTransaction) {
            $detailTransaction->delete(); // Hapus entri
            return response()->json(['message' => 'Detail transaction deleted successfully.'], 200);
        }

        return response()->json(['message' => 'Detail transaction not found.'], 404);
    }

}
