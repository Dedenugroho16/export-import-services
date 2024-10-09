<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Helpers\IdHashHelper;
use App\Models\Country;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Consignee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
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

    public function index()
    {
        $transactions = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('transaction.index', compact('transactions'));
    }

    public function create($id)
    {
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

        // Ambil semua detail transaksi yang berhubungan dengan transaksi tersebut
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();


        return view('transaction.show', compact('transaction', 'detailTransactions'));
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
        $id = IdHashHelper::decode($hash);
        $transaction = Transaction::findOrFail($id);

        // Ambil semua detail transaksi yang berhubungan dengan transaksi tersebut
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();


        return view('packing_list.show', compact('transaction', 'detailTransactions'));
    }
    // akhir fungsi tampilan Packing List


    // fungsi - fungsi Proforma Invoice
    public function proformaIndex()
    {
        $proformaInvoice = Transaction::all(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'total']);
        return view('proforma.index', compact('proformaInvoice'));
    }

    // Mengambil Proforma yang belum disetujui
    public function getProformaData()
    {
        // Mengambil data hanya yang approved = 0
        $proformaInvoice = Transaction::with(['client', 'consignee'])
            ->where('approved', 0) // Kondisi approved harus 0
            ->select(['id', 'code', 'number', 'date', 'id_client', 'id_consignee']);

        return DataTables::of($proformaInvoice)
            ->addColumn('client', function ($row) {
                return $row->client->name;  // Asumsikan ada relasi `client` di model Transaction
            })
            ->addColumn('consignee', function ($row) {
                return $row->consignee->name;  // Asumsikan ada relasi `consignee` di model Transaction
            })
            ->addColumn('aksi', function ($row) {
                $hashId = IdHashHelper::encode($row->id);
                $lihatDetail = '<a href="' . route('proforma.show', $row->id) . '" class="btn btn-sm btn-warning">Lihat Detail</a> ';
                $edit = ' <a href="' . route('proforma.edit', $hashId) . '" class="btn btn-sm btn-danger">Edit</a> ';
                return $lihatDetail . $edit . ' <button class="btn btn-sm btn-success approve-btn" data-id="' . $row->id . '">Setujui</button> ';
            })
            ->rawColumns(['aksi'])  // Agar kolom aksi dapat merender HTML
            ->make(true);
    }

    public function approveProforma($id)
    {
        // Cari transaksi berdasarkan ID dan update field approved menjadi 1
        $transaction = Transaction::findOrFail($id);
        $transaction->approved = 1;
        $transaction->save();

        // Kembalikan respons sukses
        return response()->json(['success' => 'Proforma invoice disetujui.']);
    }

    // Mengambil Proforma yang telah disetujui
    public function getApprovedData()
    {
        $approvedInvoices = Transaction::with(['client', 'consignee'])
            ->where('approved', 1) // Mengambil transaksi yang disetujui
            ->select(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'stuffing_date']); // Tambahkan stuffing_date ke dalam select

        return DataTables::of($approvedInvoices)
            ->addColumn('client', function ($row) {
                return $row->client->name;  // Mengambil nama client dari relasi
            })
            ->addColumn('consignee', function ($row) {
                return $row->consignee->name;  // Mengambil nama consignee dari relasi
            })
            ->addColumn('aksi', function ($row) {
                // Link untuk melihat detail
                $lihatDetail = '<a href="' . route('proforma.show', $row->id) . '" class="btn btn-sm btn-info">Lihat Detail</a>';

                // Cek jika stuffing_date bernilai null, tampilkan tombol "Buat Invoice"
                $buatInvoice = '';
                if (is_null($row->stuffing_date)) {
                    $buatInvoice = '<a href="' . route('transaction.create', ['id' => $row->id]) . '" class="btn btn-sm btn-success">Buat Invoice</a>';
                }

                return $lihatDetail . ' ' . $buatInvoice; // Menggabungkan kedua link
            })
            ->rawColumns(['aksi'])  // Agar kolom aksi dapat merender HTML
            ->make(true);
    }

    public function proformaCreate()
    {
        $consignees = Consignee::all();
        $clients = Client::all();
        $products = Product::all();
        $commodities = Commodity::all();
        $country = Country::all();

        // Mengambil number terakhir dari tabel transaction
        $lastTransaction = Transaction::orderBy('number', 'desc')->first();

        // Jika belum ada data di kolom number, mulai dari 0001
        if ($lastTransaction === null || empty($lastTransaction->number)) {
            $newNumber = '0001';
        } else {
            // Mengambil number terakhir dan menambah 1, pastikan tetap 4 digit
            $lastNumber = intval($lastTransaction->number);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        // Mengambil dua digit tanggal saat ini
        $twoDigitDate = date('d');

        // Menggabungkan $newNumber dengan dua digit tanggal
        $formattedNumber = $newNumber . '/' . $twoDigitDate;

        return view('proforma.create', compact('consignees', 'clients', 'products', 'commodities', 'country', 'formattedNumber'));
    }

    public function proformaStore(Request $request)
    {
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
            'stuffing_date' => 'nullable|date',
            'bl_number' => 'nullable|string|max:255',
            'container_number' => 'nullable|string|max:255',
            'seal_number' => 'nullable|string|max:255',
            'product_ncm' => 'required|string|max:255',
            'freight_cost' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'approved' => 'nullable|boolean',
        ]);

        // Simpan transaksi
        $transaction = Transaction::create($validatedData);

        // Kembalikan response JSON dengan ID transaksi yang baru
        return response()->json(['id' => $transaction->id], 201);
    }

    public function proformaShow($id)
    {
        return view('proforma.show');
    }

    public function proformaEdit(string $hash)
    {
        // Dekode hash menjadi ID
        $id = IdHashHelper::decode($hash);

        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Ambil data lain yang diperlukan untuk form
        $consignees = Consignee::all();
        $clients = Client::all();
        $products = Product::all();
        $commodities = Commodity::all();
        $country = Country::all();

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

        // mencari detail product
        // Ambil semua detail transaksi yang berhubungan dengan transaksi tersebut
        $detailTransactions = DetailTransaction::where('id_transaction', $transaction->id)->get();

        // Kirim semua data yang dibutuhkan ke view
        return view('proforma.edit', compact(
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
            'consigneeSelectedAddress'
        ));
    }

    public function proformaUpdate(Request $request, string $id)
    {
        //
    }
}
