<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\BillOfPayment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BillOfPaymentController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('bill-of-payments.index', compact('transactions'));
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
}
