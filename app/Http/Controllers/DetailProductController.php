<?php

namespace App\Http\Controllers;

use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    public function index()
    {
        $detailProducts = DetailProduct::with('product')->get();
        return view('detail-products.index', compact('detailProducts'));
    }

    // Method untuk menampilkan form tambah detail produk
    public function create()
    {
        $products = Product::all();
        return view('detail-products.create', compact('products'));
    }

    // Method untuk menyimpan detail produk baru
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

        return redirect()->route('detail-products.index')
                         ->with('success', 'Detail Product created successfully.');
    }

    public function show(DetailProduct $detailProduct)
    {
        return view('detail-products.show', compact('detailProduct'));
    }


    // Method untuk menampilkan form edit detail produk
    public function edit(DetailProduct $detailProduct)
    {
        $products = Product::all();
        return view('detail-products.edit', compact('detailProduct', 'products'));
    }

    // Method untuk memperbarui detail produk
    public function update(Request $request, DetailProduct $detailProduct)
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

        $detailProduct->update($request->all());

        return redirect()->route('detail-products.index')
                         ->with('success', 'Detail Product updated successfully.');
    }

    public function destroy(DetailProduct $detailProduct)
    {
        $detailProduct->delete();
        return redirect()->route('detail-products.index')->with('success', 'Detail Product deleted successfully.');
    }
    
}
