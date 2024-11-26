<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
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
            // Validasi setiap data transaksi
            $validator = Validator::make($data, [
                'id' => 'required|integer',
                'id_payment_detail' => 'required|integer',
                'transfered' => 'required|numeric|gte:0',
                'description' => 'required|string',
            ]);

            // Jika validasi gagal, hentikan proses dan kembalikan respons error
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi data payment gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Jika validasi berhasil, masukkan data ke database
            Payment::create([
                'id_transaction' => $data['id'],
                'id_payment_detail' => $data['id_payment_detail'],
                'transfered' => $data['transfered'],
                'description' => $data['description'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment Details berhasil dibuat'
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
