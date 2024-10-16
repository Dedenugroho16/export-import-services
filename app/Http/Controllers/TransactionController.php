<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Helpers\IdHashHelper;
use App\Helpers\NumberToWords;
use App\Models\Country;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Company;
use App\Models\Consignee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Models\DetailTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class TransactionController extends Controller
{
    // fungsi - fungsi invoice
    public function getInvoice()
    {
        $invoices = Transaction::with(['client', 'consignee'])
            ->where('approved', 1) // Mengambil transaksi yang disetujui
            ->whereNotNull('stuffing_date') // Mengambil transaksi yang stuffing_date tidak null
            ->select(['id', 'code', 'number', 'date', 'id_client', 'id_consignee']);

        return DataTables::of($invoices)
            ->addIndexColumn() // Menambahkan kolom nomor urut
            ->addColumn('client', function ($row) {
                return $row->client->name; // Mengambil nama client dari relasi
            })
            ->addColumn('consignee', function ($row) {
                return $row->consignee->name; // Mengambil nama consignee dari relasi
            })
            ->addColumn('aksi', function ($row) {
                $hashId = IdHashHelper::encode($row->id);
                // Tombol aksi untuk melihat detail
                $detailInvoice = '<a href="' . route('transaction.show', $hashId) . '" class="btn btn-sm btn-info">Lihat Detail</a> ';
                $packingList = '<a href="' . route('packingList.show', $hashId) . '" class="btn btn-sm btn-success">Packing List</a>';
                return $detailInvoice . $packingList;
            })
            ->rawColumns(['aksi'])  // Agar kolom aksi dapat merender HTML
            ->make(true);
    }

    public function index()
    {
        $transactions = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('transaction.index', compact('transactions'));
    }

    public function create($hash)
    {
        $id = IdHashHelper::decode($hash);
        // Logika untuk membuat invoice berdasarkan id proforma yang dipilih
        $transaction = Transaction::findOrFail($id);

        // Ambil semua detail transaksi yang berhubungan dengan proforma tersebut
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();

        // Kembalikan view yang sesuai dan oper data proforma
        return view('transaction.create', compact('transaction', 'detailTransactions'));
    }

    // method get Consignee
    public function getConsignees($client_id)
    {
        // Ambil consignees yang berelasi dengan client yang dipilih
        $consignees = Consignee::where('id_client', $client_id)->get();

        // Kembalikan response dalam bentuk JSON
        return response()->json($consignees);
    }

    // MENGAMBIL DATA DETAIL PRODUCTS
    public function getDetailProducts(Request $request)
    {
        // Jika tidak ada id_product yang dikirim, kembalikan DataTables kosong
        if (!$request->has('id_product') || empty($request->id_product)) {
            return datatables()->of(collect([])) // Mengirimkan data kosong
                ->addColumn('action', function ($row) {
                    return ''; // Kolom action kosong
                })
                ->make(true);
        }

        // Query ke DetailProduct jika id_product ada
        $query = DetailProduct::where('id_product', $request->id_product);

        // Jika query tidak mengembalikan data, DataTables akan tetap mengirimkan response
        return datatables()->of($query)
            ->addColumn('action', function ($row) {
                $btn = '<button class="btn btn-primary btn-sm">Pilih <i class="bi bi-arrow-right"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
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
    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $transaction = Transaction::findOrFail($id);
        $company = Company::first(); // Ambil data pertama dari tabel company

        // Ambil semua detail transaksi yang berhubungan dengan transaksi tersebut
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();

        // Panggil helper untuk mengonversi total menjadi kata
        $totalInWords = NumberToWords::convert($transaction->total);


        return view('transaction.show', compact('transaction', 'detailTransactions', 'totalInWords', 'company'));
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
        // Validasi data input
        $validatedData = $request->validate([
            'date' => 'required|date',
            'code' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'id_consignee' => 'required|exists:consignees,id',
            'notify' => 'required|string|max:255',
            'id_client' => 'required|exists:clients,id',
            'port_of_loading' => 'required|string|max:255',
            'place_of_receipt' => 'required|string|max:255',
            'port_of_discharge' => 'required|string|max:255',
            'place_of_delivery' => 'required|string|max:255',
            'id_product' => 'required|exists:products,id',
            'id_commodity' => 'required|exists:commodities,id',
            'container' => 'required|string|max:255',
            'net_weight' => 'required|numeric|min:0',
            'gross_weight' => 'required|numeric|min:0',
            'payment_term' => 'required|string|max:255',
            'stuffing_date' => 'required|date',
            'bl_number' => 'required|string|max:255',
            'container_number' => 'required|string|max:255',
            'seal_number' => 'required|string|max:255',
            'product_ncm' => 'required|string|max:255',
            'freight_cost' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'approved' => 'nullable|boolean',
        ]);

        try {
            // Cari transaksi berdasarkan ID
            $transaction = Transaction::findOrFail($id);

            // Update data transaksi
            $transaction->update($validatedData);

            // Kembalikan response JSON sukses dengan ID transaksi yang diperbarui
            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat!',
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan saat membuat invoice: ', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat invoice: ' . $e->getMessage()  // Pesan error diubah
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // Akhir fungsi - fungsi invoice

    // fungsi tampilan Packing List
    public function packingListShow($hash)
    {
        $id = IdHashHelper::decode($hash); // Decode hash untuk mendapatkan ID
        $transaction = Transaction::findOrFail($id);
        $company = Company::first(); // Ambil data pertama dari tabel company

        // Ambil semua detail transaksi yang berhubungan dengan transaksi tersebut
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();

        // Encode ID untuk mengirim ke tampilan
        $hashedId = IdHashHelper::encode($id);

        return view('packing_list.show', compact('transaction', 'detailTransactions', 'company', 'hashedId'));
    }
    // akhir fungsi tampilan Packing List

    public function exportPdf($hashId)
    {
        // Decode hashed ID menggunakan IdHashHelper
        $decodedId = IdHashHelper::decode($hashId);

        $transaction = Transaction::where('id', $decodedId)->firstOrFail();

        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();

        
        $path = 'storage/'.$company->logo;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        
        $pdf = PDF::loadView('packing_list.pdf', compact('transaction', 'detailTransactions', 'company', 'logo'));

        // Setel orientasi halaman jika perlu (optional)
        $pdf->setPaper('A4', 'portrait');

        // Return file PDF dengan nama packing_list_<id>.pdf
        return $pdf->stream('packing_list_' . $hashId . '.pdf');
    }

}