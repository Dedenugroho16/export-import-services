<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Clients;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\BillOfPayment;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\Auth;

class PaymentDetailController extends Controller
{
    // public function paymentDetails($hash)
    // {
    //     $id = IdHashHelper::decode($hash);
    //     $company = Company::first();
    //     $billOfPayment = BillOfPayment::with(['client', 'descBills.transaction'])->findOrFail($id);
    //     $totalPaid = 0;

    //     foreach ($billOfPayment->transactions as $transaction) {
    //         $transaction->formatted_date = \Carbon\Carbon::parse($transaction->date)->format('M d, Y');
    //         $totalPaid += $transaction->paid;
    //     }

    //     $totalInWords = NumberToWords::convert($totalPaid);
    //     $hashedId = IdHashHelper::encode($id);

    //     return view('bill-of-payments.payment-details', compact('company', 'billOfPayment', 'totalPaid', 'totalInWords', 'hashedId'));
    // }

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
    public function create($hash)
    {
        $id = IdHashHelper::decode($hash);
        $billOfPayment = BillOfPayment::with(['descBills'], ['client'])->findOrFail($id);

        // Mengambil number terakhir dari tabel transaction
        $lastPaymentNumber = PaymentDetail::orderBy('payment_number', 'desc')->first();
        // Jika belum ada data di kolom number, mulai dari 0001
        if ($lastPaymentNumber === null || empty($lastPaymentNumber->payment_number)) {
            $newPaymentNumber = '0001';
        } else {
            // Mengambil number terakhir dan menambah 1, pastikan tetap 4 digit
            $paymentNumber = intval($lastPaymentNumber->payment_number);
            $newPaymentNumber = str_pad($paymentNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        $year = date('Y');
        $formattedPaymentNumber = $newPaymentNumber . '.' . $year . '/PSN/PM.OF';

        return view('payment-details.create', compact('formattedPaymentNumber', 'billOfPayment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'id_bill_of_payment' => 'required',
            'payment_number' => 'required',
            'id_client' => 'required',
            'total' => 'required|numeric|gte:0',
        ], [
            'total.gte' => 'Nilai paid tidak boleh melebihi nilai bill.',
        ]);

        $data['created_by'] = Auth::id();
        // Cari BillOfPayment berdasarkan id_bill_of_payment
        $billOfPayment = BillOfPayment::find($data['id_bill_of_payment']);

        if ($billOfPayment) {
            // Ubah status BillOfPayment
            $billOfPayment->status = 1;
            $billOfPayment->save(); // Simpan perubahan ke database
        }
        $paymentDetail = PaymentDetail::create($data);

        // Return the id of the created paymentDetail
        return response()->json([
            'success' => true,
            'id_pd' => $paymentDetail->id
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
