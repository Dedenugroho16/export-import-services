<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BillOfPayment;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\IdHashHelper;

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
}
