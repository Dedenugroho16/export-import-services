<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Client;
use App\Models\Clients;
use App\Models\Company;
use App\Models\Country;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Consignee;
use App\Models\Transaction;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\BillOfPayment;
use App\Models\DetailProduct;
use App\Models\PaymentDetail;
use App\Helpers\NumberToWords;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\Auth;
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

                // Membuat dropdown aksi
                $dropdown = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="' . route('transaction.show', $hashId) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                            Lihat Detail</a></li>
                            <li><a class="dropdown-item" href="' . route('packingList.show', $hashId) . '">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
                            Packing List</a></li>
                        </ul>
                    </div>';

                return $dropdown; // Mengembalikan dropdown
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
                // Menggunakan hash ID untuk tautan
                $hashId = IdHashHelper::encode($row->id);

                // Membuat dropdown aksi
                $dropdown = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

                // Cek jika stuffing_date bernilai null, tampilkan tombol "Konfirmasi" hanya untuk role admin dan director
                if (is_null($row->stuffing_date)) {
                    if (in_array(auth()->user()->role, ['admin', 'operator'])) {
                        $dropdown .= '<li><a class="dropdown-item text-success" href="' . route('transaction.create', ['id' => $hashId]) . '">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-dashed-check me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95" /><path d="M3.69 8.56a9 9 0 0 0 -.69 3.44" /><path d="M3.69 15.44a9 9 0 0 0 1.95 2.92" /><path d="M8.56 20.31a9 9 0 0 0 3.44 .69" /><path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95" /><path d="M20.31 15.44a9 9 0 0 0 .69 -3.44" /><path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92" /><path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69" /><path d="M9 12l2 2l4 -4" /></svg>
                        Konfirmasi</a></li>';
                    }
                }

                // Menambahkan item lain dalam dropdown
                $dropdown .= '
                    <li><a class="dropdown-item" href="' . route('transaction.show', $hashId) . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                        Lihat Detail</a></li>
                    <li><a class="dropdown-item" href="' . route('packingList.show', $hashId) . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
                        Packing List</a></li>';

                $dropdown .= '</ul>
                    </div>';

                return $dropdown;
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
        $productSelected = Product::findOrFail($transaction->id_product);

        // Ambil data lain yang diperlukan untuk form
        $consignees = Consignee::all();
        $clients = Client::all();
        $products = Product::all();
        $commodities = Commodity::all();
        $countries = Country::all();

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

        $countrySelected = null;
        $transactionCode = $transaction->code; // Example: RESTO ID2410

        // Extract two uppercase letters before the numbers in the transaction code
        // Fetch the selected country object based on the code
        if (preg_match('/([A-Z]{2})(?=\d+)/', $transactionCode, $matches)) {
            $countryCode = $matches[1]; // 'ID'

            // Find the country based on the code
            $countryOld = Country::where('code', $countryCode)->firstOrFail();
            // Pass the whole country object instead of just the ID
            $countrySelected = $countryOld; // This is now an object, not just an ID
        }

        // number
        $transactionNumber = $transaction->number; // 0002/09.CR ID/10/INV/X/24
        // Memisahkan string berdasarkan titik ('.') untuk memisahkan bagian pertama
        $parts = explode('.', $transactionNumber);
        // Ambil bagian pertama sebelum titik
        $formattedNumber = $parts[0]; // Hasil: 0002/09

        // Kirim semua data yang dibutuhkan ke view
        return view('transaction.create', compact(
            'transaction',  // Transaction data to edit
            'consignees',
            'clients',
            'products',
            'productSelected',
            'productSelectedID',
            'commodities',
            'commoditySelectedID',
            'countries',  // Ensure it's plural for consistency
            'countrySelected',
            'formattedNumber',
            'clientSelected', // Changed to send the whole object
            'clientSelectedAddress',
            'consigneeSelected', // Changed to send the whole object
            'consigneeSelectedAddress',
            'selectedProductIds',
            'hash'
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

        $query = DetailProduct::query();

        if ($request->id_product == 1) {
            // Jika id_product = 1, carikan DetailProduct dengan id_product = 1 dan 2
            $query->whereIn('id_product', [1, 2])
            ->orderByRaw('id_product = 1 DESC');
        } else {
            // Jika selain itu, jalankan query seperti biasa
            $query->where('id_product', $request->id_product);
        }

        // Eksekusi query
        $results = $query->get();

        // Jika query tidak mengembalikan data, DataTables akan tetap mengirimkan response
        return datatables()->of($results)
            // ->addColumn('action', function ($row) {
            //     $btn = '<button class="btn btn-primary btn-sm">Pilih <i class="bi bi-arrow-right"></i></button>';
            //     return $btn;
            // })
            // ->rawColumns(['action'])
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
        $transaction = Transaction::findOrFail($id)->getUserRelations();
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
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $transaction->approverUser->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');


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

        $pdf = PDF::loadView('packing_list.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phoneIcon', 'emailIcon', 'phoneNumber', 'email', 'signature', 'background', 'address'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('packing_list_' . $hashId . '.pdf');
    }

    public function completingInvoice(Request $request, string $id)
    {
        // Validasi data yang dikirim
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
            'bl_number' => 'nullable|string|max:255',
            'container_number' => 'nullable|string|max:255',
            'seal_number' => 'nullable|string|max:255',
            'product_ncm' => 'required|string|max:255',
            'payment_condition' => 'required|string|max:255',
            'freight_cost' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'approved' => 'nullable|boolean',
        ]);

        // Tambahkan id pengguna yang melakukan konfirmasi
        $validatedData['confirmed_by'] = Auth::id();

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Update data transaksi dengan data yang sudah divalidasi
        $transaction->update($validatedData);

        // Kembalikan response JSON dengan status sukses
        return response()->json(['message' => 'Proforma updated successfully'], 200);
    }

    public function downloadPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $transaction = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $transaction->approverUser->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');


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

        $pdf = PDF::loadView('packing_list.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phoneIcon', 'emailIcon', 'phoneNumber', 'email', 'signature', 'background', 'address'));
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
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $transaction->approverUser->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');


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

        $pdf = PDF::loadView('transaction.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'totalInWords', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phoneIcon', 'emailIcon', 'phoneNumber', 'email', 'signature', 'background', 'address'));
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
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $transaction->approverUser->signature_url ?? null;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        $logo = $company && !empty($company->logo) && Storage::exists($company->logo)
            ? ImageHelper::getBase64Image('storage/' . $company->logo)
            : ImageHelper::getBase64Image('storage/logo.png');


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

        $pdf = PDF::loadView('transaction.pdf', compact('transaction', 'detailTransactions', 'company', 'logo', 'totalInWords', 'totalCarton', 'totalInner', 'totalNetWeight', 'priceAmount', 'phoneIcon', 'emailIcon', 'phoneNumber', 'email', 'signature', 'background', 'address'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('invoice_' . $hashId . '.pdf');
    }

    public function getAccountStatementInvoicesData(Request $request)
    {
        if ($request->ajax()) {
            $year = $request->input('year');
            $company_id = $request->input('company_id');

            // Ambil data client berdasarkan nama perusahaan
            // $clientIds = Client::where('client_company_id', $company_id)->pluck('id');

            // Query transaksi dengan filter tahun dan id_client yang sesuai
            $transactions = Transaction::query()
                ->select(['date', 'number', 'total'])
                ->where('approved', 1)
                ->where('id_client_company', $company_id) // Filter hanya transaksi dengan id_client sesuai
                ->when($year, function ($query, $year) {
                    return $query->whereYear('date', $year);
                });

            return DataTables::of($transactions)
                ->addColumn('balance', function ($transaction) {
                    static $cumulativeBalance = 0;
                    $cumulativeBalance += $transaction->total;
                    return $cumulativeBalance;
                })
                ->editColumn('date', function ($transaction) {
                    return date('d/m/Y', strtotime($transaction->date));
                })
                ->make(true);
        }
    }

    public function getAccountStatementPaymentsData(Request $request)
    {
        if ($request->ajax()) {
            $year = $request->input('year');
            $company_id = $request->input('company_id');

            $payments = PaymentDetail::query()
                ->select(['date', 'payment_number', 'total'])
                ->where('id_client_company', $company_id) // Filter hanya transaksi dengan id_client sesuai
                ->when($year, function ($query, $year) {
                    return $query->whereYear('date', $year);
                })
                ->orderByRaw("CASE WHEN payment_number LIKE '%OPENING BALANCE%' THEN 1 ELSE 2 END")
                ->orderBy('date', 'asc');

            return DataTables::of($payments)
                ->addColumn('total', function ($payment) {
                    return $payment->total; // Nilai default 0
                })
                ->addColumn('balance', function ($payment) {
                    static $cumulativeBalance = 0;
                    $paymentTotal = $payment->total ?: 0; // Nilai default 0
                    $cumulativeBalance += $paymentTotal;
                    return $cumulativeBalance;
                })
                ->editColumn('date', function ($transaction) {
                    return date('d/m/Y', strtotime($transaction->date));
                })
                ->make(true);
        }
    }

    public function AccountStatement(Request $request)
    {
        $year = $request->input('yearSelect');
        $company_id = $request->input('company_id');

        return view('transaction.AccountStatement', compact('year', 'company_id'));
    }

    public function accountStatementPdf(Request $request)
    {
        $year = $request->input('yearSelect');
        $company_id = $request->input('company_id');
        $logo = ImageHelper::getBase64Image('storage/logo1.png');
        $clientIds = Client::where('client_company_id', $company_id)->pluck('id');
        $user = Auth::user();
        $signatureUrl = $user->signature_url;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        // Query transaksi dengan filter tahun dan id_client yang sesuai
        $transactions = Transaction::query()
            ->select(['date', 'number', 'total'])
            ->where('approved', 1)
            ->whereIn('id_client', $clientIds)
            ->when($year, function ($query, $year) {
                return $query->whereYear('date', $year);
            })
            ->get();

        // Saldo kumulatif untuk transaksi
        $cumulativeBalanceTransactions = 0;
        foreach ($transactions as $transaction) {
            $transaction->balance = $cumulativeBalanceTransactions += $transaction->total;
            $transaction->date = date('d/m/Y', strtotime($transaction->date));
        }

        // Query pembayaran dengan filter tahun dan id_client_company yang sesuai
        $payments = PaymentDetail::query()
            ->select(['date', 'payment_number', 'total'])
            ->where('id_client_company', $company_id)
            ->when($year, function ($query, $year) {
                return $query->whereYear('date', $year);
            })
            ->orderByRaw("CASE WHEN payment_number LIKE '%OPENING BALANCE%' THEN 1 ELSE 2 END")
            ->orderBy('date', 'asc')
            ->get();

        // Hitung saldo kumulatif untuk pembayaran
        $cumulativeBalancePayments = 0;
        foreach ($payments as $payment) {
            $paymentTotal = $payment->total ?: 0;
            $payment->balance = $cumulativeBalancePayments += $paymentTotal;
            $payment->date = date('d/m/Y', strtotime($payment->date));
        }

        $data = [
            'logo' => $logo,
            'year' => $year,
            'company_id' => $company_id,
            'transactions' => $transactions,
            'payments' => $payments,
            'user' => $user,
            'signature' => $signature,
        ];

        // Load view untuk membuat PDF
        $pdf = PDF::loadView('transaction.AccountStatementPdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('account_statement.pdf');
    }

    public function accountStatementDownload(Request $request)
    {
        $year = $request->input('yearSelect');
        $company_id = $request->input('company_id');
        $logo = ImageHelper::getBase64Image('storage/logo1.png');
        $clientIds = Client::where('client_company_id', $company_id)->pluck('id');
        $user = Auth::user();
        $signatureUrl = $user->signature_url;
        $signature = $signatureUrl ? ImageHelper::getBase64Image('storage/' . $signatureUrl) : null;

        // Query transaksi dengan filter tahun dan id_client yang sesuai
        $transactions = Transaction::query()
            ->select(['date', 'number', 'total'])
            ->where('approved', 1)
            ->whereIn('id_client', $clientIds)
            ->when($year, function ($query, $year) {
                return $query->whereYear('date', $year);
            })
            ->get();

        // Saldo kumulatif untuk transaksi
        $cumulativeBalanceTransactions = 0;
        foreach ($transactions as $transaction) {
            $transaction->balance = $cumulativeBalanceTransactions += $transaction->total;
            $transaction->date = date('d/m/Y', strtotime($transaction->date));
        }

        // Query pembayaran dengan filter tahun dan id_client_company yang sesuai
        $payments = PaymentDetail::query()
            ->select(['date', 'payment_number', 'total'])
            ->where('id_client_company', $company_id)
            ->when($year, function ($query, $year) {
                return $query->whereYear('date', $year);
            })
            ->orderByRaw("CASE WHEN payment_number LIKE '%OPENING BALANCE%' THEN 1 ELSE 2 END")
            ->orderBy('date', 'asc')
            ->get();

        // Hitung saldo kumulatif untuk pembayaran
        $cumulativeBalancePayments = 0;
        foreach ($payments as $payment) {
            $paymentTotal = $payment->total ?: 0;
            $payment->balance = $cumulativeBalancePayments += $paymentTotal;
            $payment->date = date('d/m/Y', strtotime($payment->date));
        }

        $data = [
            'logo' => $logo,
            'year' => $year,
            'company_id' => $company_id,
            'transactions' => $transactions,
            'payments' => $payments,
            'user' => $user,
            'signature' => $signature,
        ];

        // Load view untuk membuat PDF
        $pdf = PDF::loadView('transaction.AccountStatementPdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('account_statement.pdf');
    }

    public function rekapSales(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Jika tidak ada filter tanggal, kembalikan data kosong
            if (empty($startDate) || empty($endDate)) {
                return DataTables::of(collect([]))->make(true);
            }

            $query = Transaction::with('detailTransactions')
                ->whereBetween('stuffing_date', [$startDate, $endDate]);

            $transactions = $query->get();

            // Jika tidak ada transaksi berdasarkan rentang tanggal yang dipilih
            if ($transactions->isEmpty()) {
                return DataTables::of(collect([]))->make(true);
            }

            foreach ($transactions as $transaction) {
                $transaction->total_price_amount = $transaction->detailTransactions->sum('price_amount');
            }

            $totalNetWeight = formatCurrency($transactions->sum('net_weight'));
            $totalGrossWeight = formatCurrency($transactions->sum('gross_weight'));
            $totalFreightCost = formatCurrency($transactions->sum('freight_cost'));
            $totalAmount = formatCurrency($transactions->sum('total_price_amount'));
            $total = formatCurrency($transactions->sum('total'));

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('total', fn($transaction) => formatCurrency($transaction->total))
                ->addColumn('total_price_amount', fn($transaction) => formatCurrency($transaction->total_price_amount))
                ->editColumn('net_weight', fn($transaction) => formatCurrency($transaction->net_weight))
                ->editColumn('gross_weight', fn($transaction) => formatCurrency($transaction->gross_weight))
                ->editColumn('freight_cost', fn($transaction) => formatCurrency($transaction->freight_cost))
                ->with([
                    'totalNetWeight' => $totalNetWeight,
                    'totalGrossWeight' => $totalGrossWeight,
                    'totalFreightCost' => $totalFreightCost,
                    'totalAmount' => $totalAmount,
                    'total' => $total
                ])
                ->make(true);
        }

        return view('transaction.rekap');
    }

    public function rekapPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi tanggal
        if (!$startDate || !$endDate) {
            return redirect()->route('transactions.rekap')->withErrors('Please provide a valid date range.');
        }

        // Parsing tanggal
        $startDate = Carbon::parse($startDate)->toDateString();
        $endDate = Carbon::parse($endDate)->toDateString();

        // Query data transaksi berdasarkan rentang tanggal
        $transactions = Transaction::whereBetween('stuffing_date', [$startDate, $endDate])
            ->with('detailTransactions')
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->total_price_amount = $transaction->detailTransactions->sum('price_amount');
        }

        $totalNetWeight = formatCurrency($transactions->sum('net_weight'));
        $totalGrossWeight = formatCurrency($transactions->sum('gross_weight'));
        $totalFreightCost = formatCurrency($transactions->sum('freight_cost'));
        $totalAmount = formatCurrency($transactions->sum('total_price_amount'));
        $total = formatCurrency($transactions->sum('total'));

        $filterApplied = true;

        $pdf = PDF::loadView('transaction.rekapPdf', compact(
            'transactions',
            'startDate',
            'endDate',
            'filterApplied',
            'totalAmount',
            'totalNetWeight',
            'totalGrossWeight',
            'totalFreightCost',
            'total'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('rekap_sales_' . date('Ymd') . '.pdf');
    }

    public function downloadRekapPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi tanggal
        if (!$startDate || !$endDate) {
            return redirect()->route('transactions.rekap')->withErrors('Please provide a valid date range.');
        }

        // Parsing tanggal
        $startDate = Carbon::parse($startDate)->toDateString();
        $endDate = Carbon::parse($endDate)->toDateString();

        // Query data transaksi berdasarkan rentang tanggal
        $transactions = Transaction::whereBetween('stuffing_date', [$startDate, $endDate])
            ->with('detailTransactions')
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->total_price_amount = $transaction->detailTransactions->sum('price_amount');
        }

        $totalNetWeight = formatCurrency($transactions->sum('net_weight'));
        $totalGrossWeight = formatCurrency($transactions->sum('gross_weight'));
        $totalFreightCost = formatCurrency($transactions->sum('freight_cost'));
        $totalAmount = formatCurrency($transactions->sum('total_price_amount'));
        $total = formatCurrency($transactions->sum('total'));

        $filterApplied = true;

        $pdf = PDF::loadView('transaction.rekapPdf', compact(
            'transactions',
            'startDate',
            'endDate',
            'filterApplied',
            'totalAmount',
            'totalNetWeight',
            'totalGrossWeight',
            'totalFreightCost',
            'total'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('rekap_sales_' . date('Ymd') . '.pdf');
    }
}