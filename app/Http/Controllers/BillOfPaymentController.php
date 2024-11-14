<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Helpers\NumberToWords;
use App\Models\BillOfPayment;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
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
        $billOfPayments = BillOfPayment::with(['client', 'transactions'])
            ->select(['id', 'month', 'no_inv', 'id_client', 'status']);

        return DataTables::of($billOfPayments)
            ->addIndexColumn() // Tambahkan baris ini
            ->addColumn('client_name', function ($row) {
                return $row->client ? $row->client->name : '-';
            })
            ->addColumn('company_name', function ($row) {
                return $row->client ? $row->client->company_name : '-';
            })
            ->addColumn('number', function ($row) {
                return $row->transactions->isNotEmpty() ? $row->transactions->first()->number : '-';
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Payment Details
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
            return datatables()->of(collect([]))->make(true); // Kembalikan data kosong jika `id_client` tidak ada
        }

        $invoices = Transaction::where('approved', 1)
            ->whereNotNull('stuffing_date')
            ->whereNull('id_bill')
            ->where('id_client', $request->id_client);

        return datatables()->of($invoices)
            ->addIndexColumn()
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
            'total' => 'required',
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

    public function PIUpdate(Request $request)
    {
        // Ambil data transactions dari request
        $transactions = $request->input('transactions');

        foreach ($transactions as $data) {
            // Ambil id dari setiap data
            $transaction = Transaction::find($data['id']);

            if ($transaction) {
                // Update data transaksi
                $transaction->description = $data['description'];
                $transaction->paid = $data['paid'];
                $transaction->id_bill = $data['id_bill'];
                // Tambahkan field lain sesuai kebutuhan
                $transaction->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Bil of Payment berhasil dibuat'
        ]);
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with(['client', 'transactions.detailTransactions'])->findOrFail($id);
        $billOfPayment->transactions->load('detailTransactions');

        $totalBill = 0;
        foreach ($billOfPayment->transactions as $transaction) {
            $amount = $transaction->detailTransactions->sum('price_amount');
            $transaction->amount = $amount;
            $transaction->totalBill = $amount - $transaction->paid;
        }

        $totalInWords = NumberToWords::convert($transaction->totalBill);
        $hashedId = IdHashHelper::encode($id);

        return view('bill-of-payments.show', compact('company', 'billOfPayment', 'hashedId', 'totalBill', 'totalInWords'));
    }

    public function paymentDetails($hash)
    {
        $id = IdHashHelper::decode($hash);
        $company = Company::first();
        $billOfPayment = BillOfPayment::with(['client', 'transactions.detailTransactions'])->findOrFail($id);
        $totalPaid = 0;

        foreach ($billOfPayment->transactions as $transaction) {
            $amount = $transaction->detailTransactions->sum('price_amount');
            $transaction->amount = $amount;
            $totalPaid += $transaction->paid;
        }

        $totalInWords = NumberToWords::convert($totalPaid);

        return view('bill-of-payments.payment-details', compact('company', 'billOfPayment', 'totalPaid', 'totalInWords'));
    } 
}