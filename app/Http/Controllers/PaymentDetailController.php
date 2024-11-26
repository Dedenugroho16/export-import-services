<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentDetailController extends Controller
{
    public function paymentDetails($hash)
    {
        $id = IdHashHelper::decode($hash);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with(['client', 'descBills.transaction'])->findOrFail($id);
        $totalPaid = 0;

        foreach ($billOfPayment->transactions as $transaction) {
            $transaction->formatted_date = \Carbon\Carbon::parse($transaction->date)->format('M d, Y');
            $totalPaid += $transaction->paid;
        }

        $totalInWords = NumberToWords::convert($totalPaid);
        $hashedId = IdHashHelper::encode($id);

        return view('bill-of-payments.payment-details', compact('company', 'billOfPayment', 'totalPaid', 'totalInWords', 'hashedId'));
    }

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
