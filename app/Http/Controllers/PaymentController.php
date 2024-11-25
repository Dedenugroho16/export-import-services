<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailTransaction;

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
            Payment::create([
                'id_transaction' => $data['id'],
                'id_bill' => $data['id_bill'],
                'paid' => $data['paid'],
                'description' => $data['description'],
            ]);
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
