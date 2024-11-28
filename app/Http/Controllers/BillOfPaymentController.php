<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Transaction;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\BillOfPayment;
use App\Helpers\NumberToWords;
use App\Models\PaymentDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BillOfPaymentController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('bill-of-payments.index', compact('transactions'));
    }

    public function getBillOfPayment()
    {
        $billOfPayments = BillOfPayment::with(['client', 'descBills'])
            ->select(['id', 'month', 'no_inv', 'id_client', 'status']);

        return DataTables::of($billOfPayments)
            ->addIndexColumn() // Tambahkan baris ini
            ->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '-';
            })
            ->addColumn('company_name', function ($row) {
                return $row->client ? $row->client->company_name : '-';
            })
            ->addColumn('aksi', function ($row) {
                $hashId = IdHashHelper::encode($row->id);
                return '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . route('bill-of-payments.details', $hashId) . '" class="dropdown-item">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
                                Lihat Payment Details
                            </a>
                            <a href="' . route('bill-of-payment.show', $hashId) . '" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                Tampilkan
                            </a>
                            <a href="' . route('bill-of-payment.edit', $hashId) . '" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Edit
                            </a>
                        </div>
                    </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        // Mengambil number terakhir dari tabel transaction
        $lastBillOfDateNo = BillOfPayment::orderBy('no_inv', 'desc')->first();

        // Jika belum ada data di kolom number, mulai dari 0001
        if ($lastBillOfDateNo === null || empty($lastBillOfDateNo->no_inv)) {
            $newNumber = '0001';
        } else {
            // Mengambil number terakhir dan menambah 1, pastikan tetap 4 digit
            $lastNumber = intval($lastBillOfDateNo->no_inv);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        // Mengambil dua digit tanggal saat ini
        $twoDigitMonth = date('m');

        // Menggabungkan $newNumber dengan dua digit tanggal
        $formattedNumber = $newNumber . '/' . $twoDigitMonth;

        return view('bill-of-payments.create', compact('formattedNumber'));
    }

    public function getProformaInvoices(Request $request)
    {
        if (!$request->has('id_client') || empty($request->id_client)) {
            return datatables()->of(collect([]))->make(true); // Data kosong jika `id_client` tidak ada
        }

        $invoices = Transaction::where('approved', 1)
            ->where('id_client', $request->id_client)
            ->whereRaw('total <> (SELECT COALESCE(SUM(transfered), 0) FROM payments WHERE payments.id_transaction = transactions.id)')
            ->with('payments') // Pastikan relasi payments dimuat
            ->get();

        return datatables()->of($invoices)
            ->addIndexColumn()
            ->addColumn('total_paid', function ($row) {
                return $row->payments->sum('transfered');
            })
            ->addColumn('amount', function ($row) {
                return $row->total;
            })
            ->addColumn('aksi', function ($row) {
                return '<button class="btn btn-primary btn-sm pilih-btn">Pilih</button>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // In your BillOfPaymentController
    public function store(Request $request)
    {
        $data = $request->validate([
            'month' => 'required',
            'no_inv' => 'required',
            'id_client' => 'required',
            'total' => 'required|numeric|gte:0',
        ], [
            'total.gte' => 'Nilai paid tidak boleh melebihi nilai bill.',
        ]);

        $data['created_by'] = Auth::id();

        // Save the BillOfPayment
        $billOfPayment = BillOfPayment::create($data);

        // Return the id of the created BillOfPayment
        return response()->json([
            'success' => true,
            'id_bill' => $billOfPayment->id
        ]);
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with([
            'client',
            'createdBy',
            'descBills.transaction',
        ])->findOrFail($id);

        $totalBill = 0;

        foreach ($billOfPayment->descBills as $descBill) {
            $transaction = $descBill->transaction;
            $transaction->bill = $transaction->total - $descBill->paid;
            $totalBill += $transaction->bill;
        }

        $totalInWords = NumberToWords::convert($totalBill);
        $hashedId = IdHashHelper::encode($id);

        return view('bill-of-payments.show', compact('company', 'billOfPayment', 'hashedId', 'totalBill', 'totalInWords'));
    }

    public function details(Request $request, $hash)
    {
        $billId = IdHashHelper::decode($hash);
        $billOfPayment = BillOfPayment::with('client')->findOrFail($billId);

        if ($request->ajax()) {
            $payment_details = PaymentDetail::where('id_bill_of_payment', $billId);

            return DataTables::of($payment_details)
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $actionBtn = '
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="' . route('payment-details.show', $hashId) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                    Tampilkan
                                </a>
                                <a class="dropdown-item" href="' . route('consignees.edit', $hashId) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit
                                </a>
                            </div>
                        </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('bill-of-payments.details', compact('billOfPayment', 'hash'));
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);

        $billOfPayment = BillOfPayment::with(['descBills'], ['client'])->findOrFail($id);

        return view('bill-of-payments.edit', compact('billOfPayment'));
    }

    public function getTransactions($idBill)
    {
        try {
            // Ambil data transaksi dengan relasi ke desc_bills dan payments
            $transactions = Transaction::whereHas('descBills', function ($query) use ($idBill) {
                $query->where('id_bill', $idBill);
            })
                ->with([
                    'descBills' => function ($query) use ($idBill) {
                        $query->where('id_bill', $idBill) // Filter hanya untuk $idBill
                            ->select('id_transaction', 'description', 'paid');
                    }
                ])
                ->select(
                    'transactions.id',
                    'transactions.number',
                    'transactions.code',
                    'transactions.total'
                )
                ->get();

            // Gabungkan description dari desc_bills dan total_paid dari payments
            $transactions = $transactions->map(function ($transaction) {
                $transaction->description = $transaction->descBills->pluck('description');
                $transaction->paid = $transaction->descBills->pluck('paid');
                return $transaction;
            });

            return response()->json($transactions);
        } catch (\Exception $e) {
            \Log::error("Error fetching transactions: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi input data
        $data = $request->validate([
            'month' => 'required',
            'no_inv' => 'required',
            'id_client' => 'required',
            'total' => 'required|numeric|gte:0',
        ], [
            'total.gte' => 'Nilai paid tidak boleh melebihi nilai bill.',
        ]);

        // Dapatkan BillOfPayment berdasarkan ID
        $billOfPayment = BillOfPayment::findOrFail($id);

        // Perbarui data yang divalidasi
        $data['updated_by'] = Auth::id(); // Tambahkan updated_by sebagai ID pengguna yang mengedit

        // Lakukan update pada data BillOfPayment
        $billOfPayment->update($data);

        // Kembalikan respons JSON sebagai feedback sukses dengan ID BillOfPayment yang diperbarui
        return response()->json([
            'success' => true,
            'id_bill' => $billOfPayment->id
        ]);
    }

    public function bopExportPdf($hashId)
    {
        $id = IdHashHelper::decode($hashId);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with([
            'client',
            'createdBy',
            'descBills.transaction',
        ])->findOrFail($id);

        $totalBill = 0;
        foreach ($billOfPayment->descBills as $descBill) {
            if ($descBill->transaction) {
                $transaction = $descBill->transaction;
                $transaction->bill = $transaction->total - $descBill->paid;
                $totalBill += $transaction->bill;
            }
        }

        $totalInWords = NumberToWords::convert($totalBill);
        $hashedId = IdHashHelper::encode($id);

        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $signatureUrl = $billOfPayment->createdBy->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;
        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');

        $phoneNumber = $company->phone_number ?? '-';
        $email = $company->email ?? '-';
        $address = $company->address ?? '-';

        $pdf = PDF::loadView('bill-of-payments.billofpaymentsPdf', compact(
            'logo',
            'company',
            'billOfPayment',
            'hashedId',
            'totalBill',
            'totalInWords',
            'phoneIcon',
            'emailIcon',
            'phoneNumber',
            'email',
            'signature',
            'address',
            'background'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('bill-of-payment_' . $hashId . '.pdf');
    }

    public function bopDownloadPdf($hashId)
    {
        $id = IdHashHelper::decode($hashId);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with([
            'client',
            'createdBy',
            'descBills.transaction',
        ])->findOrFail($id);

        $totalBill = 0;
        foreach ($billOfPayment->descBills as $descBill) {
            if ($descBill->transaction) {
                $transaction = $descBill->transaction;
                $transaction->bill = $transaction->total - $descBill->paid;
                $totalBill += $transaction->bill;
            }
        }

        $totalInWords = NumberToWords::convert($totalBill);
        $hashedId = IdHashHelper::encode($id);

        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $signatureUrl = $billOfPayment->createdBy->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;
        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');

        $phoneNumber = $company->phone_number ?? '-';
        $email = $company->email ?? '-';
        $address = $company->address ?? '-';

        $pdf = PDF::loadView('bill-of-payments.billofpaymentsPdf', compact(
            'logo',
            'company',
            'billOfPayment',
            'hashedId',
            'totalBill',
            'totalInWords',
            'phoneIcon',
            'emailIcon',
            'phoneNumber',
            'email',
            'signature',
            'address',
            'background'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('bill-of-payment_' . $hashId . '.pdf');
    }

    public function paymentDetailstDownload($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with(['client', 'transactions.detailTransactions'])->findOrFail($decodedId);
        $billOfPayment->transactions->load('detailTransactions');
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $billOfPayment->createdBy->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;
        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');

        $totalPaid = 0;

        foreach ($billOfPayment->transactions as $transaction) {
            $transaction->formatted_date = \Carbon\Carbon::parse($transaction->date)->format('M d, Y');
            $totalPaid += $transaction->paid;
        }

        $totalInWords = NumberToWords::convert($totalPaid);
        $hashedId = IdHashHelper::encode($decodedId);

        $pdf = PDF::loadView('bill-of-payments.paymentDetailsPdf', compact('logo', 'company', 'billOfPayment', 'hashedId', 'totalPaid', 'totalInWords', 'phoneIcon', 'emailIcon', 'phoneNumber', 'email', 'signature', 'address', 'background'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('payment-details_' . $hashId . '.pdf');
    }
}
