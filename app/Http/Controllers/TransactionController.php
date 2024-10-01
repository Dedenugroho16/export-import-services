<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Country;
use App\Models\Product;
use App\Models\Commodity;
use App\Models\Consignee;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use Yajra\DataTables\Facades\DataTables;


class TransactionController extends Controller
{
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
    public function create()
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

        return view('transaction.create', compact('consignees', 'clients', 'products', 'commodities', 'country', 'formattedNumber'));
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
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
