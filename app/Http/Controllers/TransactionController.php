<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Models\Country;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Consignee;
use App\Models\Transaction;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\DetailProduct;
use App\Helpers\NumberToWords;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailTransaction;
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

    public function getIncompleteInvoice()
    {
        $approvedInvoices = Transaction::with(['client', 'consignee'])
            ->where('approved', 1) // Mengambil transaksi yang disetujui
            ->whereNull('stuffing_date') // Hanya data yang stuffing_date bernilai null
            ->select(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'stuffing_date']);

        return DataTables::of($approvedInvoices)
            ->addColumn('client', function ($row) {
                return $row->client->name;  // Mengambil nama client dari relasi
            })
            ->addColumn('consignee', function ($row) {
                return $row->consignee->name;  // Mengambil nama consignee dari relasi
            })
            ->addColumn('aksi', function ($row) {
                // Link untuk melihat detail
                $hashId = IdHashHelper::encode($row->id);
                $lihatDetail = '<a href="' . route('transaction.show', $hashId) . '" class="btn btn-sm btn-info">Lihat Detail</a> ';

                // Cek jika stuffing_date bernilai null, tampilkan tombol "Buat Invoice"
                $lengkapi = '';
                if (is_null($row->stuffing_date)) {
                    $hashId = IdHashHelper::encode($row->id);
                    $lengkapi = '<a href="' . route('transaction.create', ['id' => $hashId]) . '" class="btn btn-sm btn-success">Lengkapi</a>';
                }

                $packingList = '<a href="' . route('packingList.show', $hashId) . '" class="btn btn-sm btn-warning">Packing List</a>';

                return $lihatDetail . ' ' . $packingList . ' ' . $lengkapi; // Menggabungkan kedua link
            })
            ->rawColumns(['aksi'])  // Agar kolom aksi dapat merender HTML
            ->make(true);
    }

    public function incomplete()
    {
        $transactions = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('transaction.incomplete', compact('transactions'));
    }

    public function index()
    {
        $transactions = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('transaction.index', compact('transactions'));
    }

    public function create($hash)
    {
        // Dekode hash menjadi ID
        $id = IdHashHelper::decode($hash);

        $transaction = Transaction::with(['detailTransactions'])->findOrFail($id);

        // Ambil data lain yang diperlukan untuk form
        $consignees = Consignee::all();
        $clients = Client::all();
        $products = Product::all();
        $commodities = Commodity::all();
        $country = Country::all();

        // Ambil ID produk dari detail transaksi yang sudah ada
        $selectedProductIds = $transaction->detailTransactions->pluck('id_detail_product')->toArray();

        // mencari product dan commodity yang terpilih
        $productSelectedID = $transaction->id_product;
        $commoditySelectedID = $transaction->id_commodity;

        // mencari client yang sudah terpilih
        $clientSelectedID = $transaction->id_client;
        $clientSelected = Client::findOrFail($clientSelectedID);
        $clientSelectedAddress = $clientSelected->address;

        // mencari consignee yang sudah terpilih
        $consigneeSelectedID = $transaction->id_consignee;
        $consigneeSelected = Consignee::findOrFail($consigneeSelectedID);
        $consigneeSelectedAddress = $consigneeSelected->address;

        // mencari Negara yang sudah terpilih
        $transactionCode = $transaction->code; // contoh: RESTO ID2410
        // Ekstrak dua huruf kapital sebelum angka
        if (preg_match('/([A-Z]{2})(?=\d+)/', $transactionCode, $matches)) {
            $countryCode = $matches[1]; // 'ID'

            // Cari negara berdasarkan kode yang diekstrak
            $countryOld = Country::where('code', $countryCode)->firstOrFail();
            $countrySelected = $countryOld->id;
        }

        // number
        $transactionNumber = $transaction->number; // 0002/09.CR ID/10/INV/X/24
        // Memisahkan string berdasarkan titik ('.') untuk memisahkan bagian pertama
        $parts = explode('.', $transactionNumber);
        // Ambil bagian pertama sebelum titik
        $formattedNumber = $parts[0]; // Hasil: 0002/09

        // Kirim semua data yang dibutuhkan ke view
        return view('transaction.create', compact(
            'transaction',  // Data transaksi yang perlu diedit
            'consignees',
            'clients',
            'products',
            'productSelectedID',
            'commodities',
            'commoditySelectedID',
            'country',
            'countrySelected',
            'formattedNumber',
            'clientSelectedID',
            'clientSelectedAddress',
            'consigneeSelectedID',
            'consigneeSelectedAddress',
            'selectedProductIds',
            'hash',
        ));
    }

    // public function create($hash)
    // {
    //     $id = IdHashHelper::decode($hash);
    //     // Logika untuk membuat invoice berdasarkan id proforma yang dipilih
    //     $transaction = Transaction::findOrFail($id);

    //     // Ambil semua detail transaksi yang berhubungan dengan proforma tersebut
    //     $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();

    //     // Kembalikan view yang sesuai dan oper data proforma
    //     return view('transaction.create', compact('transaction', 'detailTransactions'));
    // }

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
        $company = Company::first();
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();
        $totalInWords = NumberToWords::convert($transaction->total);
        $hashedId = IdHashHelper::encode($id);


        return view('transaction.show', compact('transaction', 'detailTransactions', 'totalInWords', 'company', 'hashedId'));
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
            'payment_condition' => 'required|string|max:255',
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

    // fungsi tampilan Packing List
    public function packingListShow($hash)
    {
        $id = IdHashHelper::decode($hash);
        $transaction = Transaction::findOrFail($id);
        $company = Company::first();
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();
        $hashedId = IdHashHelper::encode($id);

        return view('packing_list.show', compact('transaction', 'detailTransactions', 'company', 'hashedId'));
    }

    public function exportPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $transaction = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $logo = ImageHelper::getBase64Image('storage/' . $company->logo);
        $ttd = ImageHelper::getBase64Image('storage/ttd.png');
        $phone = ImageHelper::getBase64Image('storage/phone.png');
        $email = ImageHelper::getBase64Image('storage/mail.png');

        $totalCarton = 0;
        $totalInner = 0;
        $totalNetWeight = 0;
        $priceAmount = 0;

        foreach ($detailTransactions as $detail) {
            $totalCarton += $detail->carton;
            $totalInner += $detail->inner_qty_carton;
            $totalNetWeight += $detail->net_weight;
            $priceAmount += $detail->price_amount;
        }

        $pdf = PDF::loadView('packing_list.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'ttd', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phone', 'email'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('packing_list_' . $hashId . '.pdf');
    }

    public function downloadPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $transaction = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $logo = ImageHelper::getBase64Image('storage/' . $company->logo);
        $ttd = ImageHelper::getBase64Image('storage/ttd.png');
        $phone = ImageHelper::getBase64Image('storage/phone.png');
        $email = ImageHelper::getBase64Image('storage/mail.png');

        $totalCarton = 0;
        $totalInner = 0;
        $totalNetWeight = 0;
        $priceAmount = 0;

        foreach ($detailTransactions as $detail) {
            $totalCarton += $detail->carton;
            $totalInner += $detail->inner_qty_carton;
            $totalNetWeight += $detail->net_weight;
            $priceAmount += $detail->price_amount;
        }

        $pdf = PDF::loadView('packing_list.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'ttd', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phone', 'email'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('packing_list_' . $hashId . '.pdf');
    }

    public function transactionExportPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $transaction = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $totalInWords = NumberToWords::convert($transaction->total);
        $logo = ImageHelper::getBase64Image('storage/' . $company->logo);
        $ttd = ImageHelper::getBase64Image('storage/ttd.png');
        $phone = ImageHelper::getBase64Image('storage/phone.png');
        $email = ImageHelper::getBase64Image('storage/mail.png');

        $totalCarton = 0;
        $totalInner = 0;
        $totalNetWeight = 0;
        $priceAmount = 0;

        foreach ($detailTransactions as $detail) {
            $totalCarton += $detail->carton;
            $totalInner += $detail->inner_qty_carton;
            $totalNetWeight += $detail->net_weight;
            $priceAmount += $detail->price_amount;
        }

        $pdf = PDF::loadView('transaction.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'totalInWords', 'ttd', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phone', 'email'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('invoice_' . $hashId . '.pdf');
    }

    public function transactionDownloadPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $transaction = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $totalInWords = NumberToWords::convert($transaction->total);
        $logo = ImageHelper::getBase64Image('storage/' . $company->logo);
        $ttd = ImageHelper::getBase64Image('storage/ttd.png');
        $phone = ImageHelper::getBase64Image('storage/phone.png');
        $email = ImageHelper::getBase64Image('storage/mail.png');

        $totalCarton = 0;
        $totalInner = 0;
        $totalNetWeight = 0;
        $priceAmount = 0;

        foreach ($detailTransactions as $detail) {
            $totalCarton += $detail->carton;
            $totalInner += $detail->inner_qty_carton;
            $totalNetWeight += $detail->net_weight;
            $priceAmount += $detail->price_amount;
        }

        $pdf = PDF::loadView('transaction.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'totalInWords', 'ttd', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phone', 'email'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('invoice_' . $hashId . '.pdf');
    }
}