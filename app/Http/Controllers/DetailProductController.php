<?php

namespace App\Http\Controllers;

use App\Models\DetailProduct;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $detailProducts = DetailProduct::all();
        return view('detail_products.index', compact('detailProducts'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('detail_products.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required|integer',
            'name' => 'required|string|max:255',
            'pcs' => 'required|integer',
            'dimension' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        DetailProduct::create($request->all());

        return redirect()->route('detail-products.index')->with('success', 'Detail Product created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $detailProduct = DetailProduct::findOrFail($id);
        return view('detail_products.show', compact('detailProduct'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $detailProduct = DetailProduct::findOrFail($id);
        return view('detail_products.edit', compact('detailProduct'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_product' => 'required|integer',
            'name' => 'required|string|max:255',
            'pcs' => 'required|integer',
            'dimension' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $detailProduct = DetailProduct::findOrFail($id);
        $detailProduct->update($request->all());

        return redirect()->route('detail-products.index')->with('success', 'Detail Product updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $detailProduct = DetailProduct::findOrFail($id);
        $detailProduct->delete();

        return redirect()->route('detail-products.index')->with('success', 'Detail Product deleted successfully.');
    }
}

