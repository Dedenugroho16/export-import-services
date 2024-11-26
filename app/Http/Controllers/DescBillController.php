<?php

namespace App\Http\Controllers;

use App\Models\DescBill;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DescBillController extends Controller
{
    public function store(Request $request)
    {
        // Ambil data transactions dari request
        $transactions = $request->input('transactions');

        foreach ($transactions as $data) {
            // Validasi setiap data transaksi
            $validator = Validator::make($data, [
                'id' => 'required|integer',
                'id_bill' => 'required|integer',
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
            DescBill::create([
                'id_transaction' => $data['id'],
                'id_bill' => $data['id_bill'],
                'description' => $data['description'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bill of Payment berhasil dibuat'
        ]);
    }
}
