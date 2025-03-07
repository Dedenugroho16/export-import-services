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
use App\Models\ClientCompany;
use App\Models\Clients;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProformaController extends Controller
{
    public function index()
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
                return $row->client->name;
            })
            ->addColumn('consignee', function ($row) {
                return $row->consignee->name;
            })
            ->addColumn('aksi', function ($row) {
                $hashId = IdHashHelper::encode($row->id);

                // Start of action buttons logic
                if (auth()->user()->role == 'finance') {
                    // For role finance, replace dropdown with a simple "Lihat" button
                    return '
                        <a href="' . route('proforma.show', $hashId) . '" class="btn btn-success">
                            Lihat
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right ms-1" style="margin: 0;">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M17 7l-10 10" />
                                <path d="M8 7l9 0l0 9" />
                            </svg>
                        </a>';
                }

                // Default dropdown for roles other than finance
                $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">';

                // Check for admin or director role to show approval button
                if (in_array(auth()->user()->role, ['director', 'admin'])) {
                    $actionBtn .= '
                        <button class="dropdown-item approve-btn text-success" data-id="' . $row->id . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox me-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 11l3 3l8 -8" />
                                <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                            </svg>
                            Setujui
                        </button>';
                }

                // Always include the 'Lihat Detail' button
                $actionBtn .= '
                    <a href="' . route('proforma.show', $hashId) . '" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M17 7l-10 10" />
                            <path d="M8 7l9 0l0 9" />
                        </svg>
                        Lihat Detail
                    </a>';

                // Include 'Edit' button for admin and operator roles
                if (in_array(auth()->user()->role, ['admin', 'operator'])) {
                    $actionBtn .= '
                        <a href="' . route('proforma.edit', $hashId) . '" class="dropdown-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                <path d="M16 5l3 3"/>
                            </svg>
                            Edit
                        </a>';
                }

                $actionBtn .= '
                        </div>
                    </div>';

                return $actionBtn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function approveProforma($id)
    {
        // Cek apakah pengguna yang sedang login adalah director atau admin
        if (!in_array(auth()->user()->role, ['director', 'admin'])) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk menyetujui Proforma.'], 403);
        }

        // Periksa apakah signature_url pengguna sudah terisi
        if (empty(auth()->user()->signature_url)) {
            return response()->json(['error' => 'Anda harus melengkapi tanda tangan untuk menyetujui Proforma.'], 400);
        }

        $transaction = Transaction::findOrFail($id);

        if ($transaction->approved == 1) {
            return response()->json(['error' => 'Proforma invoice sudah disetujui sebelumnya.'], 400);
        }

        // Update field approved menjadi 1, simpan ID approver dan waktu persetujuan
        $transaction->approved = 1;
        $transaction->approver = auth()->user()->id;
        $transaction->approved_at = now();
        $transaction->save();

        return response()->json(['success' => 'Proforma invoice disetujui.']);
    }

    // Mengambil Proforma yang telah disetujui
    public function getApprovedData()
    {
        $approvedInvoices = Transaction::with(['client', 'consignee'])
            ->where('approved', 1)
            ->select(['id', 'code', 'number', 'date', 'id_client', 'id_consignee', 'stuffing_date']);

        return DataTables::of($approvedInvoices)
            ->addColumn('client', function ($row) {
                return $row->client->name;
            })
            ->addColumn('consignee', function ($row) {
                return $row->consignee->name;
            })
            ->addColumn('aksi', function ($row) {
                $hashId = IdHashHelper::encode($row->id);

                // Jika role pengguna adalah admin atau operator, tampilkan dropdown
                if (in_array(auth()->user()->role, ['admin', 'operator'])) {
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . route('proforma.show', $hashId) . '" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                Lihat Detail
                            </a>
                            <a href="' . route('proforma.edit', $hashId) . '" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    <path d="M16 5l3 3"/>
                                </svg>
                                Edit
                            </a>
                        </div>
                    </div>';
                } else {
                    $actionBtn = '
                    <a href="' . route('proforma.show', $hashId) . '" class="btn btn-success">
                        Lihat
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right ms-1" style="margin: 0;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                    </a>';
                }

                return $actionBtn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function create()
    {
        $consignees = Consignee::all();
        $clients = Client::all();
        $products = Product::all();
        $commodities = Commodity::all();

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

        return view('proforma.create', compact('consignees', 'clients', 'products', 'commodities', 'formattedNumber'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'code' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'id_consignee' => 'required|exists:consignees,id',
            'notify' => 'required|string|max:255',
            'id_client' => 'required|exists:clients,id',
            'id_client_company' => 'required|exists:client_company,id',
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
            'payment_condition' => 'required|string|max:255',
            'freight_cost' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'approved' => 'nullable|boolean',
        ]);

        $validatedData['created_by'] = Auth::id();

        $transaction = Transaction::create($validatedData);

        // Kembalikan response JSON dengan ID transaksi yang baru
        return response()->json(['id' => $transaction->id], 201);
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $proformaInvoice = Transaction::findOrFail($id)->getUserRelations();
        $company = Company::first();
        $detailTransactions = DetailTransaction::where('id_transaction', $id)->get();
        $totalInWords = NumberToWords::convert($proformaInvoice->total);
        $approved = $proformaInvoice->approved;
        $hashedId = IdHashHelper::encode($id);

        return view('proforma.show', compact('proformaInvoice', 'detailTransactions', 'totalInWords', 'approved', 'company', 'hashedId'));
    }

    // mengambil detail product
    public function editGetDetailProducts(Request $request)
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

    public function getDetailTransaction($idTransaction)
    {
        // Query untuk mendapatkan detail transaksi berdasarkan id_transaction dengan alias untuk menghindari konflik nama kolom
        $detailTransactions = DetailTransaction::where('detail_transactions.id_transaction', $idTransaction)
            ->join('detail_products', 'detail_transactions.id_detail_product', '=', 'detail_products.id')
            ->select(
                'detail_transactions.*',
                'detail_transactions.id as detail_transaction_id', // Alias id transaksi detail
                'detail_transactions.id_transaction',               // Menambahkan id_transaction
                'detail_transactions.id_detail_product',            // Alias id produk detail
                'detail_transactions.qty',
                'detail_transactions.carton',
                'detail_transactions.price_amount',
                'detail_transactions.net_weight',
                'detail_products.name as product_name',
                'detail_products.pcs',
                'detail_products.dimension',
                'detail_products.type',
                'detail_products.color',
                'detail_products.price as unit_price'
            )
            ->get();

        // Kembalikan data dalam format JSON
        return response()->json($detailTransactions);
    }

    public function getSelectedProductIds(int $id)
    {
        // Ambil transaksi berdasarkan ID dan muat detail transaksi terkait
        $transaction = Transaction::with(['detailTransactions'])->findOrFail($id);

        // Ambil ID produk dari detail transaksi yang sudah ada
        $selectedProductIds = $transaction->detailTransactions->pluck('id_detail_product')->toArray();

        // Kembalikan response JSON
        return response()->json([
            'selectedProductIds' => $selectedProductIds
        ]);
    }

    public function edit(string $hash)
    {
        // Decode hash to ID
        $id = IdHashHelper::decode($hash);

        // Retrieve the transaction along with its detail transactions
        $transaction = Transaction::with(['detailTransactions'])->findOrFail($id);
        $productSelected = Product::findOrFail($transaction->id_product);

        // Retrieve necessary data for the form
        $consignees = Consignee::all();
        $clients = Client::all();
        $products = Product::all();
        $commodities = Commodity::all();
        $countries = Country::all();
        $clientCompany = ClientCompany::all();

        // Extract the selected product and commodity IDs
        $productSelectedID = $transaction->id_product;
        $commoditySelectedID = $transaction->id_commodity;

        // Retrieve the selected client and their address
        $clientSelected = Clients::findOrFail($transaction->id_client);

        $companySelected = ClientCompany::findOrFail($transaction->id_client_company);
        $companySelectedAddress = $companySelected->address;

        // Retrieve the selected consignee and their address
        $consigneeSelected = Consignee::findOrFail($transaction->id_consignee);
        $consigneeSelectedAddress = $consigneeSelected->address;

        // Determine the selected country based on the transaction code
        $countrySelected = null;
        $transactionCode = $transaction->code;
        
        if (preg_match('/([A-Z]{2,3})(?=\d+)/', $transactionCode, $matches)) {
            $countryCode = $matches[1]; // 'ID' atau 'HAM'

            // Cari negara berdasarkan kode
            $countryOld = Country::where('code', $countryCode)->first();

            if ($countryOld) {
                // Pass the whole country object instead of just the ID
                $countrySelected = $countryOld; // Ini adalah objek, bukan hanya ID
            } else {
                // Tindakan jika kode negara tidak ditemukan
                \Log::warning("Country code not found: {$countryCode}");
                $countrySelected = null; // Atau beri nilai default
            }
        } else {
            \Log::error("Country code pattern not matched in transaction code: {$transactionCode}");
            $countrySelected = null; // Atau beri nilai default
        }

        // Extract the transaction number
        $transactionNumber = $transaction->number; // e.g., 0002/09.CR ID/10/INV/X/24
        $parts = explode('.', $transactionNumber);

        // Get the formatted number (the part before the first dot)
        $formattedNumber = $parts[0]; // Result: 0002/09

        // Collect selected product IDs from detail transactions
        $selectedProductIds = $transaction->detailTransactions->pluck('id_detail_product')->toArray();

        // Send all necessary data to the view
        return view('proforma.edit', compact(
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
            'consigneeSelected', // Changed to send the whole object
            'consigneeSelectedAddress',
            'selectedProductIds',
            'companySelected',
            'companySelectedAddress',
            'hash'
        ));
    }

    public function update(Request $request, string $id)
    {
        // Validasi data yang dikirim
        $validatedData = $request->validate([
            'date' => 'required|date',
            'code' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'id_consignee' => 'required|exists:consignees,id',
            'notify' => 'required|string|max:255',
            'id_client' => 'required|exists:clients,id',
            'id_client_company' => 'required|exists:client_company,id',
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
            'payment_condition' => 'required|string|max:255',
            'freight_cost' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'approved' => 'nullable|boolean',
        ]);

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Tambahkan ID user yang sedang login ke data yang divalidasi
        $validatedData['edited_by'] = Auth::id();

        // Update data transaksi dengan data yang sudah divalidasi
        $transaction->update($validatedData);

        // Kembalikan response JSON dengan status sukses
        return response()->json(['message' => 'Proforma updated successfully'], 200);
    }

    public function proformaExportPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $proformaInvoice = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $totalInWords = NumberToWords::convert($proformaInvoice->total);
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $proformaInvoice->approverUser->signature_url ?? null;
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

        $pdf = PDF::loadView('proforma.pdf', compact(
            'proformaInvoice',
            'detailTransactions',
            'company',
            'logo',
            'totalInWords',
            'totalCarton',
            'totalInner',
            'totalNetWeight',
            'priceAmount',
            'phoneIcon',
            'emailIcon',
            'phoneNumber',
            'email',
            'signature',
            'background',
            'address'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('proforma_' . $hashId . '.pdf');
    }


    public function proformaDownloadPdf($hashId)
    {
        $decodedId = IdHashHelper::decode($hashId);
        $proformaInvoice = Transaction::where('id', $decodedId)->firstOrFail();
        $detailTransactions = DetailTransaction::where('id_transaction', $decodedId)->get();
        $company = Company::first();
        $totalInWords = NumberToWords::convert($proformaInvoice->total);
        $phoneIcon = ImageHelper::getBase64Image('storage/phone.png');
        $emailIcon = ImageHelper::getBase64Image('storage/mail.png');
        $background = ImageHelper::getBase64Image('storage/background.jpg');
        $phoneNumber = $company ? $company->phone_number : '';
        $email = $company ? $company->email : '';
        $address = $company ? $company->address : '';
        $signatureUrl = $proformaInvoice->approverUser->signature_url ?? null;
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

        $pdf = PDF::loadView('proforma.pdf', compact(
            'proformaInvoice',
            'detailTransactions',
            'company',
            'logo',
            'totalInWords',
            'totalCarton',
            'totalInner',
            'totalNetWeight',
            'priceAmount',
            'phoneIcon',
            'emailIcon',
            'phoneNumber',
            'email',
            'signature',
            'background',
            'address'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('proforma_' . $hashId . '.pdf');
    }

    public function getConsigneesByClient($clientId)
    {
        // Mengambil consignee sesuai id_client
        $query = Consignee::where('id_client', $clientId);
        $totalRecords = $query->count();
        $consignees = $query->get();

        // Pastikan tidak ada output lain
        return response()->json([
            'draw' => intval(request()->get('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $consignees
        ]);
    }

    public function getClientCompanies($clientId)
    {
        // Tangani kasus di mana $clientId adalah 0
        if ($clientId == 0) {
            return response()->json([
                'draw' => intval(request()->get('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        // Cari client berdasarkan ID
        $client = Clients::find($clientId);

        // Jika client tidak ditemukan, kembalikan response kosong
        if (!$client) {
            return response()->json([
                'draw' => intval(request()->get('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        // Ambil clientCompanies terkait
        $clientCompanies = $client->clientCompanies;

        // Mengembalikan data dalam format yang sesuai untuk DataTables
        return response()->json([
            'draw' => intval(request()->get('draw')),
            'recordsTotal' => $clientCompanies->count(),
            'recordsFiltered' => $clientCompanies->count(),
            'data' => $clientCompanies
        ]);
    }

    public function getClients(Request $request)
    {
        $search = $request->get('q');

        // Query untuk mencari client berdasarkan input
        $clients = Clients::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->select('id', 'name') // Pilih hanya field yang diperlukan
            ->paginate(10); // Batasi hasil per halaman

        // Format response untuk Select2
        $formattedClients = $clients->items();
        $results = [];
        foreach ($formattedClients as $client) {
            $results[] = [
                'id' => $client->id,
                'text' => $client->name,
            ];
        }

        return response()->json([
            'results' => $results,
            'pagination' => ['more' => $clients->hasMorePages()],
        ]);
    }
}
