<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                         ->with('product_success', 'Product created successfully.');
    }

    // Display the specified product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
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
                         ->with('product_success', 'Product updated successfully.');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $product->delete();

        // Reset auto-increment for the products table
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');

        return redirect()->route('products.index')
                         ->with('product_error', 'Product deleted successfully.');
    }
}
