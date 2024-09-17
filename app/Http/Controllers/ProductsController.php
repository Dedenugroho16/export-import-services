<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper; // Import the IdHashHelper for encoding/decoding

class ProductsController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        // Ambil semua produk beserta detail produknya
        $products = Product::with('detailProducts')->get();
        
        return view('products.index', compact('products'));
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
                         ->with('product_success', 'Produk berhasil ditambahkan.');
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

        return redirect()->route('products.index')
                         ->with('product_success', 'Produk berhasil di update');
    }

    // Remove the specified product from storage
    public function destroy($hash)
    {
        // Decode the hash to get the product's ID
        $id = IdHashHelper::decode($hash);
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('product_success', 'Produk berhasil di hapus.');
    }

    public function showDetails($hash)
    {
        // Decode the hash to get the product's ID
        $id = IdHashHelper::decode($hash);
        $product = Product::with('detailProducts')->findOrFail($id);

        // Kirim data produk dan detail produk ke view
        return view('products.details', compact('product'));
    }
}
