<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Helpers\ImageHelper;
use App\Helpers\NumberToWords;
use App\Models\BillOfPayment;
use App\Models\Company;
use App\Models\PaymentDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $company = Company::first();
    
        $paymentDetail = PaymentDetail::with([
            'client',
            'createdBy',
            'payments.transaction'
        ])->findOrFail($id);

        foreach ($paymentDetail->payments as $payment) {
            if ($payment->transaction) {
                $payment->transaction->formatted_date = \Carbon\Carbon::parse($payment->transaction->date)->format('M d, Y');
            }
        }

        $totalInWords = NumberToWords::convert($paymentDetail->total);
        $hashedId = IdHashHelper::encode($paymentDetail->id);
       return view('payment-details.show', compact('paymentDetail', 'company', 'totalInWords', 'hashedId'));
    }    

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

    public function exportPdf($hashedId)
    {
        $id = IdHashHelper::decode($hashedId);
        $company = Company::first();
        $paymentDetail = PaymentDetail::with([
            'client',
            'createdBy',
            'payments.transaction'
        ])->findOrFail($id);

        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $totalInWords = NumberToWords::convert($paymentDetail->total);

        $signatureUrl = $paymentDetail->createdBy->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');


        foreach ($paymentDetail->payments as $payment) {
            if ($payment->transaction) {
                $payment->transaction->formatted_date = \Carbon\Carbon::parse($payment->transaction->date)->format('M d, Y');
            }
        }

        $pdf = PDF::loadView('payment-details.pdf', compact(
            'logo', 
            'company', 
            'hashedId',
            'totalInWords', 
            'phoneIcon', 
            'emailIcon', 
            'phoneNumber', 
            'email', 
            'signature', 
            'address', 
            'background', 
            'paymentDetail'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('payment-details_' . $hashedId . '.pdf');
    }

    public function downloadPdf($hashedId)
    {
        $id = IdHashHelper::decode($hashedId);
        $company = Company::first();
        $paymentDetail = PaymentDetail::with([
            'client',
            'createdBy',
            'payments.transaction'
        ])->findOrFail($id);

        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $totalInWords = NumberToWords::convert($paymentDetail->total);

        $signatureUrl = $paymentDetail->createdBy->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');


        foreach ($paymentDetail->payments as $payment) {
            if ($payment->transaction) {
                $payment->transaction->formatted_date = \Carbon\Carbon::parse($payment->transaction->date)->format('M d, Y');
            }
        }
        
        $pdf = PDF::loadView('payment-details.pdf', compact(
            'logo', 
            'company', 
            'hashedId',
            'totalInWords', 
            'phoneIcon', 
            'emailIcon', 
            'phoneNumber', 
            'email', 
            'signature', 
            'address', 
            'background', 
            'paymentDetail'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('payment-details_' . $hashedId . '.pdf');
    }
}