<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentDetail;

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
    public function create()
    {
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

        return view('bill-of-payments.create', compact('formattedPaymentNumber'));
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
