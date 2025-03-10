<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Transaction;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\BillOfPayment;
use App\Models\PaymentDetail;
use App\Helpers\NumberToWords;
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

        $hashedBOPId = IdHashHelper::encode($billOfPayment->id);

        return view('payment-details.create', compact('formattedPaymentNumber', 'billOfPayment', 'hashedBOPId'));
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
            'id_client_company' => 'required|exists:client_company,id',
            'total' => 'required|numeric|gte:0',
        ], [
            'total.gte' => 'Nilai transfered tidak boleh melebihi nilai bill.',
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
            'client.clientCompany',
            'createdBy',
            'billOfPayment',
            'payments.transaction'
        ])->findOrFail($id);

        foreach ($paymentDetail->payments as $payment) {
            if ($payment->transaction) {
                $payment->transaction->formatted_date = \Carbon\Carbon::parse($payment->transaction->date)->format('M d, Y');
            }
        }

        $totalInWords = NumberToWords::convert($paymentDetail->total);
        $hashedId = IdHashHelper::encode($paymentDetail->id);
        $hashedBOPId = IdHashHelper::encode($paymentDetail->billOfPayment->id);
        return view('payment-details.show', compact('paymentDetail', 'company', 'totalInWords', 'hashedId', 'hashedBOPId'));
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);

        $transactions = Transaction::whereHas('payments', function ($query) use ($id) {
            $query->where('id_payment_detail', $id);
        })->get();

        $paymentDetails = PaymentDetail::with([
            'payments' => function ($query) use ($id) {
                $query->where('id_payment_detail', $id)->select('id', 'id_payment_detail', 'description');
            },
            'client',
            'billOfPayment'
        ])->findOrFail($id);

        // Gabungkan description dari relasi payments menjadi properti tambahan
        $paymentDetails->description = $paymentDetails->payments->pluck('description')->implode(', ');

        $hashedBOPId = IdHashHelper::encode($paymentDetails->billOfPayment->id);

        return view('payment-details.edit', compact('paymentDetails', 'hashedBOPId'));
    }

    public function getTransactions($idBill, $idPaymentDetail)
    {
        try {
            // Ambil data transaksi dengan relasi ke desc_bills dan payments
            $transactions = Transaction::whereHas('descBills', function ($query) use ($idBill) {
                $query->where('id_bill', $idBill);
            })
                ->with([
                    'descBills' => function ($query) use ($idBill) {
                        $query->where('id_bill', $idBill)
                            ->select('id_transaction', 'description', 'paid', 'bill');
                    },
                    'payments' => function ($query) use ($idPaymentDetail) {
                        $query->where('id_payment_detail', $idPaymentDetail)
                            ->select('id_transaction', 'description', 'transfered', 'id_payment_detail');
                    }
                ])
                ->select(
                    'transactions.id',
                    'transactions.number',
                    'transactions.code',
                    'transactions.total'
                )
                ->get();

            // Proses data untuk setiap transaksi
            $transactions = $transactions->map(function ($transaction) use ($idPaymentDetail) {
                // Ambil deskripsi dari descBills
                $transaction->description = $transaction->descBills->where('id_transaction', $transaction->id)->pluck('description')->implode(', ');
                $transaction->paid = $transaction->descBills->where('id_transaction', $transaction->id)->pluck('paid')->implode(', ');
                $transaction->bill = $transaction->descBills->where('id_transaction', $transaction->id)->pluck('bill')->implode(', ');

                // Ambil deskripsi dari payments dengan filter id_payment_detail
                $transaction->descriptionPayments = $transaction->payments
                    ->where('id_transaction', $transaction->id) // Filter berdasarkan id_transaction
                    ->where('id_payment_detail', $idPaymentDetail) // Filter tambahan berdasarkan id_payment_detail
                    ->pluck('description');

                $transaction->descriptionTransfered = $transaction->payments
                    ->where('id_transaction', $transaction->id) // Filter berdasarkan id_transaction
                    ->where('id_payment_detail', $idPaymentDetail) // Filter tambahan berdasarkan id_payment_detail
                    ->pluck('transfered');

                return $transaction;
            });

            return response()->json($transactions);
        } catch (\Exception $e) {
            \Log::error("Error fetching transactions: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'required',
            'id_bill_of_payment' => 'required',
            'payment_number' => 'required',
            'id_client' => 'required',
            'total' => 'required|numeric|gte:0',
        ], [
            'total.gte' => 'Nilai transfered tidak boleh melebihi nilai bill.',
        ]);

        // Dapatkan paymentDetail berdasarkan ID
        $paymentDetail = PaymentDetail::findOrFail($id);

        // Perbarui data yang divalidasi
        $data['updated_by'] = Auth::id();

        // Lakukan update pada data paymentDetail
        $paymentDetail->update($data);

        return response()->json([
            'success' => true,
            'id_pd' => $paymentDetail->id
        ]);
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
            'client.clientCompany',
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
            'client.clientCompany',
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

    public function openingBalanceIndex(Request $request)
    {
        if ($request->ajax()) {
            $paymentDetails = PaymentDetail::with(['client', 'clientCompany', 'createdBy'])
                ->select(['id', 'payment_number', 'date', 'id_client', 'id_client_company', 'total', 'created_by'])
                ->where('payment_number', 'like', '%(OPENING BALANCE)%')
                ->paginate(
                    $request->get('length'),
                    ['*'],
                    'page',
                    $request->get('start') / $request->get('length') + 1
                );

            $paymentDetails->getCollection()->transform(function ($paymentDetail) {
                $hashedId = IdHashHelper::encode($paymentDetail->id);

                $paymentDetail->client_name = $paymentDetail->client ? $paymentDetail->client->name : 'N/A';
                $paymentDetail->client_company_name = $paymentDetail->clientCompany ? $paymentDetail->clientCompany->company_name : 'N/A';
                $paymentDetail->created_by_name = $paymentDetail->createdBy ? $paymentDetail->createdBy->name : 'N/A';

                // Ganti dropdown dengan tombol Edit untuk role admin dan finance
                if (in_array(auth()->user()->role, ['admin', 'finance'])) {
                    $paymentDetail->action = '
                    <a href="' . route('opening-balance.edit', $hashedId) . '" class="btn btn-success">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit ms-1" style="margin: 0;">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                            <path d="M16 5l3 3"/>
                        </svg>
                    </a>
                ';
                } else {
                    $paymentDetail->action = null; // Tidak ada kolom aksi untuk role lain
                }

                return $paymentDetail;
            });

            return response()->json([
                'draw' => intval($request->get('draw')),
                'recordsTotal' => PaymentDetail::count(),
                'recordsFiltered' => $paymentDetails->total(),
                'data' => $paymentDetails->items(),
            ]);
        }

        return view('opening-balance.index');
    }


    public function openingBalanceCreate()
    {
        return view('opening-balance.create');
    }

    public function openingBalanceStore(Request $request)
    {

        $validatedData = $request->validate(
            [
                'no_inv' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/\(OPENING BALANCE\)/',
                ],
                'total' => 'required|numeric|min:0',
                'month' => 'required|string',
                'id_client' => 'required|integer|exists:clients,id',
                'id_client_company' => 'required|exists:client_company,id',
            ],
            [
                'no_inv.regex' => 'Description harus mengandung teks "(OPENING BALANCE)".',
                'total.required' => 'Payment wajib diisi.',
                'no_inv.required' => 'Description wajib diisi.',
                'id_client.required' => 'Buyer wajib diisi.',
                'id_client_company.required' => 'Company wajib diisi.',
            ]
        );

        $year = Carbon::createFromFormat('F Y', $validatedData['month'])->year;
        $existingOpeningBalance = PaymentDetail::where('id_client_company', $validatedData['id_client_company'])
            ->where('payment_number', 'like', '%(OPENING BALANCE)%')
            ->whereYear('date', $year)
            ->exists(); // Mengecek apakah sudah ada data dengan kondisi tersebut

        if ($existingOpeningBalance) {
            // Jika sudah ada, tampilkan alert menggunakan SweetAlert dan batalkan penyimpanan
            return response()->json([
                'success' => false,
                'message' => 'Perusahaan tersebut sudah memiliki opening balance pada tahun ini.'
            ], 400);
        }

        $paymentDetail = PaymentDetail::create([
            'payment_number' => $validatedData['no_inv'],
            'date' => now(),
            'id_client' => $validatedData['id_client'],
            'id_client_company' => $validatedData['id_client_company'],
            'total' => $validatedData['total'],
            'created_by' => auth()->user()->id,
            'id_bill_of_payment' => null,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        return response()->json(['success' => true]);
    }

    public function openingBalanceEdit($hashId)
    {

        $id = IdHashHelper::decode($hashId);

        $paymentDetail = PaymentDetail::findOrFail($id);

        return view('opening-balance.edit', compact('paymentDetail', 'hashId'));
    }

    public function openingBalanceUpdate(Request $request, $hashId)
    {

        $id = IdHashHelper::decode($hashId);

        $validatedData = $request->validate(
            [
                'no_inv' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/\(OPENING BALANCE\)/',
                ],
                'total' => 'required|numeric|min:0',
                'month' => 'required|string',
                'id_client' => 'required|integer|exists:clients,id',
                'id_client_company' => 'required|exists:client_company,id',
            ],
            [
                'no_inv.regex' => 'Description harus mengandung teks "(OPENING BALANCE)".',
                'total.required' => 'Payment wajib diisi.',
                'no_inv.required' => 'Description wajib diisi.',
                'id_client.required' => 'Buyer wajib diisi.',
                'id_client_company.required' => 'Company wajib diisi.',
            ]
        );


        $paymentDetail = PaymentDetail::findOrFail($id);


        $paymentDetail->update([
            'payment_number' => $validatedData['no_inv'],
            'id_client' => $validatedData['id_client'],
            'id_client_company' => $validatedData['id_client_company'],
            'total' => $validatedData['total'],
            'created_by' => auth()->user()->id,
        ]);


        session()->flash('success', 'Data berhasil diperbarui!');
        return response()->json(['success' => true]);
    }
}
