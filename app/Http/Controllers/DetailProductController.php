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

    // Method for displaying the form to add new detail product
    public function create()
    {
        $products = Product::all();
        return view('detail-products.create', compact('products'));
    }

    // Method for storing new detail product
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

    // Method for displaying the edit form
    public function edit(DetailProduct $detailProduct)
    {
        $products = Product::all();
        return view('detail-products.edit', compact('detailProduct', 'products'));
    }

    // Method for updating the detail product
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

        return redirect()->route('detail-products.index')->with('error', 'Detail Product deleted successfully.');
    }
}
