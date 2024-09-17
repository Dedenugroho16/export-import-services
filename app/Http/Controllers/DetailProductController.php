<?php

namespace App\Http\Controllers;

use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\IdHashHelper; // Import IdHashHelper

class DetailProductController extends Controller
{
    public function index()
    {
        $detailProducts = DetailProduct::with('product')->get();
        return view('detail-products.index', compact('detailProducts'));
    }

    public function create()
    {
        $products = Product::all();
        return view('detail-products.create', compact('products'));
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

        return redirect()->route('detail-products.index')->with('success', 'Detail produk berhasil ditambahkan.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::with('product')->findOrFail($id);

        return view('detail-products.show', compact('detailProduct'));
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);
        $products = Product::all();

        return view('detail-products.edit', compact('detailProduct', 'products'));
    }

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

        return redirect()->route('detail-products.index')->with('success', 'Detail produk berhasil di update.');
    }

    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $detailProduct = DetailProduct::findOrFail($id);
        $detailProduct->delete();

        return redirect()->back()->with('success', 'Detail produk berhasil di hapus.');
    }
}
