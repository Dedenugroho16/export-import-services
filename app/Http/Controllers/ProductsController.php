<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use App\Models\DetailProduct;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah request datang melalui AJAX (dari DataTables)
        if ($request->ajax()) {
            // Mengambil semua data produk dengan relasi 'detailProducts'
            $products = Product::with('detailProducts')->select('products.*');

            return DataTables::of($products)
                ->addColumn('action', function ($row) {
                    // Encode ID untuk keamanan
                    $hashId = IdHashHelper::encode($row->id);

                    // Generate action buttons
                    $actionBtn = '
                <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">
                Aksi
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . route('products.details', $hashId) . '" class="dropdown-item">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-list me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 12l.01 0" /><path d="M13 12l2 0" /><path d="M9 16l.01 0" /><path d="M13 16l2 0" /></svg>
                            Lihat Detail Produk
                            </a>
                            <a class="dropdown-item" href="' . route('products.show', $hashId) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                            Tampilkan
                            </a>
                            <a class="dropdown-item" href="' . route('products.edit', $hashId) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(\'' . route('products.destroy', $hashId) . '\')">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                Hapus
                            </a>
                        </div>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('products.index');
    }


    // Show the form for creating a new product
    public function create()
    {
        return view('products.create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:255', // Make it nullable if it's not required
        ]);

        Product::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'abbreviation' => $request->input('abbreviation'),
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    // Display the specified product
    public function show($hash)
    {
        // Decode the hash to get the product's ID
        $id = IdHashHelper::decode($hash);
        $product = Product::with('detailProducts')->findOrFail($id);

        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit($hash)
    {
        // Decode the hash to get the product's ID
        $id = IdHashHelper::decode($hash);
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, $hash)
    {
        // Decode the hash to get the product's ID
        $id = IdHashHelper::decode($hash);
        $product = Product::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:255',
        ]);

        $product->update([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'abbreviation' => $request->input('abbreviation'),
        ]);

        return redirect($request->input('previous_url', route('products.index')))
        ->with('success', 'Data berhasil diperbarui.');
    }

    // Remove the specified product from storage
    public function destroy($hash)
    {
        // Decode the hash to get the product's ID
        $id = IdHashHelper::decode($hash);
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data berhasil dihapus.');
    }

    // Show details product
    public function showDetails(Request $request, $hash)
    {
        $productId = IdHashHelper::decode($hash);

        $product = Product::findOrFail($productId);

        if ($request->ajax()) {
            $detailProducts = DetailProduct::where('id_product', $productId);

            return DataTables::of($detailProducts)
                ->addColumn('action', function ($row) {
                    $hashId = IdHashHelper::encode($row->id);
                    $actionBtn = '
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="' . route('detail-products.show', $hashId) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                    Tampilkan
                                </a>
                                <a class="dropdown-item" href="' . route('detail-products.edit', $hashId) . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item text-danger" onclick="confirmDelete(\'' . route('detail-products.destroy', $hashId) . '\')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        Hapus
                                    </a>
                                </div>
                            </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('products.details', compact('product', 'hash'));
    }

    public function getProducts(Request $request)
    {
        $search = $request->input('q'); // 'q' is the search parameter from Select2
        $products = Product::where('name', 'like', '%' . $search . '%')->get();

        $results = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'text' => $product->name,    // 'text' for Select2
                'code' => $product->code,     // Ensure 'code' matches the Select2 setup
                'abbreviation' => $product->abbreviation,
            ];
        });

        return response()->json($results);
    }
}
