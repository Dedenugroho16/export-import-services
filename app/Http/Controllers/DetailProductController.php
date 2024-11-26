<?php

namespace App\Http\Controllers;

use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper;
use Yajra\DataTables\Facades\DataTables;

class DetailProductController extends Controller
{
    public function index(Request $request)
    {
    // Check if the request is an AJAX call (from DataTables)
    if ($request->ajax()) {
        $detailProducts = DetailProduct::with('product')->select('detail_products.*');
        return DataTables::of($detailProducts)
            ->addColumn('action', function($row) {
                $hashId = \App\Helpers\IdHashHelper::encode($row->id);

                $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" data-bs-boundary="viewport" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="'.route('detail-products.show', $hashId).'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                Tampilkan
                            </a>
                            <a class="dropdown-item" href="'.route('detail-products.edit', $hashId).'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                Edit
                            </a>
                            <form action="'.route('detail-products.destroy', $hashId).'" method="POST" onsubmit="return confirm(\'Apakah anda yakin ingin menghapus data ini?\')" style="display:inline;">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="dropdown-item text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>';
                
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('detail-products.index');
    }


    public function create($hash)
    {
        // Decode hashed ID menjadi ID asli
        $productId = IdHashHelper::decode($hash);
    
        // Temukan produk berdasarkan ID asli
        $product = Product::find($productId);
    
        // Jika produk tidak ditemukan, kembalikan 404
        if (!$product) {
            abort(404);
        }
        return view('detail-products.create', [
            'product' => $product
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'pcs' => 'required|integer',
            'dimension' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        DetailProduct::create($request->all());
        $product = Product::findOrFail($request->id_product);
        $productName = $product->name;

        return redirect($request->input('previous_url', route('products.index')))->with('success', 'Data berhasil ditambahkan.');
    }

    // Display the specified detail product
    public function show($hash)
    {
        // Decode hash untuk mendapatkan ID detail produk
        $id = IdHashHelper::decode($hash);

        $detailProduct = DetailProduct::with('product')->findOrFail($id);

        // Hash ID produk untuk digunakan pada tombol "Back"
        $hashedProductId = IdHashHelper::encode($detailProduct->id_product);
        
        return view('detail-products.show', compact('detailProduct', 'hashedProductId'));
    }

    // Show the form for editing the specified detail product
    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);
        $products = Product::all();

        return view('detail-products.edit', [
            'detailProduct' => $detailProduct,
            'products' => $products,
            'hash' => $hash
        ]);
    }

    // Update the specified detail product in storage
    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);

        $request->validate([
            'id_product' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'pcs' => 'required|integer',
            'dimension' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $detailProduct->update($request->all());

        return redirect($request->input('previous_url', route('products.index')))
        ->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);
        $detailProduct->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
