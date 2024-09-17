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
        $detailProducts = DetailProduct::with('product')->get();
        return view('detail-products.index', compact('detailProducts'));
    }

    // Show the form for creating a new detail product
    public function create()
    {
        $products = Product::all();
        return view('detail-products.create', compact('products'));
    }

    // Store a newly created detail product in storage
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

        return redirect()->route('products.index')->with('details_success', 'Detail ' . $productName . ' berhasil ditambahkan.');
    }

    // Display the specified detail product
    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::with('product')->findOrFail($id);

        return view('detail-products.show', compact('detailProduct'));
    }

    // Show the form for editing the specified detail product
    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash); // Decode hash to get the ID
        $detailProduct = DetailProduct::findOrFail($id); // Find the DetailProduct by ID
        $products = Product::all(); // Get all products

        return view('detail-products.edit', [
            'detailProduct' => $detailProduct,
            'products' => $products,
            'hash' => $hash // Pass the hash to the view for the form action
        ]);
    }

    // Update the specified detail product in storage
    public function update(Request $request, $hash)
    {
        $id = IdHashHelper::decode($hash); // Decode hash to get the ID
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
        ->with('details_success', 'Detail produk berhasil diupdate.');
    }

    // Remove the specified detail product from storage
    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);
        $detailProduct->delete();

        return redirect()->back()->with('details_success', 'Detail produk berhasil dihapus.');
    }
}
