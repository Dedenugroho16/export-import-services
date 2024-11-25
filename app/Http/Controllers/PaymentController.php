<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
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
        // Ambil data transactions dari request
        $transactions = $request->input('transactions');

        foreach ($transactions as $data) {
            // Ambil id dari setiap data
            $transaction = DetailTransaction::find($data['id']);

            if ($transaction) {
                // Update data transaksi
                $transaction->description = $data['description'];
                $transaction->paid = $data['paid'];
                $transaction->id_bill = $data['id_bill'];
                // Tambahkan field lain sesuai kebutuhan
                $transaction->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Bil of Payment berhasil dibuat'
        ]);
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
