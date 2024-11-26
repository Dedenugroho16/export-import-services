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
                'paid' => 'required|numeric|gte:0',
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
                'paid' => $data['paid'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bill of Payment berhasil dibuat'
        ]);
    }

    public function update(Request $request)
    {
        // Ambil data transactions dari request
        $transactions = $request->input('transactions');

        foreach ($transactions as $data) {
            // Validasi setiap data transaksi
            $validator = Validator::make($data, [
                'id' => 'required|integer|exists:transactions,id',   // Pastikan id_transaction ada di tabel transactions
                'id_bill' => 'required|integer|exists:bill_of_payments,id',      // Pastikan id_bill ada di tabel bills
                'description' => 'required|string',                   // Deskripsi wajib ada
                'paid' => 'required|numeric|gte:0',                   // Pastikan paid adalah angka dan >= 0
            ]);

            // Jika validasi gagal, hentikan proses dan kembalikan respons error
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi data payment gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Periksa apakah data DescBill sudah ada
            $descBill = DescBill::where('id_transaction', $data['id'])
                ->where('id_bill', $data['id_bill'])
                ->first();

            if ($descBill) {
                // Jika sudah ada, update data yang ada
                $descBill->update([
                    'description' => $data['description'],  // Update description
                    'paid' => $data['paid'],                // Update paid
                ]);
            } else {
                // Jika tidak ada, beri respons bahwa data tidak ditemukan
                return response()->json([
                    'success' => false,
                    'message' => 'DescBill tidak ditemukan untuk transaksi ' . $data['id'] . ' dan bill ' . $data['id_bill'],
                ], 404);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Bill of Payment berhasil diperbarui',
        ]);
    }
}
