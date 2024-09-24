<?php

namespace App\Http\Controllers;

use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper; // Import IdHashHelper

class DetailProductController extends Controller
{
    // Display a listing of the detail products
    public function index()
    {
        // Mendapatkan detail product bersama relasi product
        $detailProducts = DetailProduct::with('product')->get();
        
        // Mengembalikan view dengan data detail products
        return view('detail-products.index', compact('detailProducts'));
    }

    // Show the form for creating a new detail product
    public function create()
    {
        // Mendapatkan semua produk untuk ditampilkan di dropdown
        $products = Product::all();

        // Mengembalikan form create
        return view('detail-products.create', compact('products'));
    }

    // Store a newly created detail product in storage
    public function store(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'product_id' => 'required|exists:products,id', // Mengganti id_product menjadi product_id sesuai dengan konvensi
            'name' => 'required|string|max:255',
            'pcs' => 'required|integer',
            'dimension' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Membuat detail product baru berdasarkan input
        DetailProduct::create($request->all());

        // Mendapatkan nama produk terkait untuk pesan sukses
        $product = Product::findOrFail($request->product_id);
        $productName = $product->name;

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('details_success', 'Detail produk ' . $productName . ' berhasil ditambahkan.');
    }

    // Display the specified detail product
    public function show($hash)
    {
        // Mendekode hash untuk mendapatkan ID
        $id = IdHashHelper::decode($hash);

        // Mendapatkan detail produk beserta relasi produk
        $detailProduct = DetailProduct::with('product')->findOrFail($id);

        // Mengembalikan view untuk menampilkan detail produk
        return view('detail-products.show', compact('detailProduct'));
    }

    // Show the form for editing the specified detail product
    public function edit($hash)
    {
        // Mendekode hash untuk mendapatkan ID detail produk
        $id = IdHashHelper::decode($hash);

        // Mendapatkan detail produk berdasarkan ID
        $detailProduct = DetailProduct::findOrFail($id);

        // Mendapatkan semua produk untuk dropdown
        $products = Product::all();

        // Mengembalikan view edit dengan data produk terkait
        return view('detail-products.edit', [
            'detailProduct' => $detailProduct,
            'products' => $products,
            'hash' => $hash // Mengirim hash ke view untuk digunakan dalam form action
        ]);
    }

    // Update the specified detail product in storage
    public function update(Request $request, $hash)
    {
        // Mendekode hash untuk mendapatkan ID detail produk
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);

        // Validasi input pengguna
        $request->validate([
            'product_id' => 'required|exists:products,id', // Mengganti id_product menjadi product_id sesuai dengan konvensi
            'name' => 'required|string|max:255',
            'pcs' => 'required|integer',
            'dimension' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        // Update data detail produk
        $detailProduct->update($request->all());

        // Redirect kembali ke halaman sebelumnya atau ke index produk
        return redirect()->route('products.index')
            ->with('details_success', 'Detail produk berhasil diupdate.');
    }

    // Remove the specified detail product from storage
    public function destroy($hash)
    {
        // Mendekode hash untuk mendapatkan ID detail produk
        $id = IdHashHelper::decode($hash);

        // Mendapatkan detail produk dan menghapusnya
        $detailProduct = DetailProduct::findOrFail($id);
        $detailProduct->delete();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('details_success', 'Detail produk berhasil dihapus.');
    }
}
