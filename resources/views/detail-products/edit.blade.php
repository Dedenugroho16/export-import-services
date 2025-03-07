@extends('layouts.layout')
@section('title', 'Detail Produk')

@section('content')
<div class="page-body">
    <div class="container-xl">
       <!-- Form Section -->
       <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
        <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Edit Detail Produk</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('detail-products.update', $hash) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            <div class="mb-3">
                                <label for="id_product" class="form-label">Produk</label>
                                <select name="id_product" id="id_product" class="form-control" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $product->id == $detailProduct->id_product ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $detailProduct->name) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="pcs" class="form-label">PCS</label>
                                <input type="number" id="pcs" name="pcs" class="form-control" value="{{ old('pcs', $detailProduct->pcs) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="dimension" class="form-label">Dimensi</label>
                                <input type="text" id="dimension" name="dimension" class="form-control" value="{{ old('dimension', $detailProduct->dimension) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="type" class="form-label">Tipe</label>
                                <input type="text" id="type" name="type" class="form-control" value="{{ old('type', $detailProduct->type) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="color" class="form-label">Warna</label>
                                <input type="text" id="color" name="color" class="form-control" value="{{ old('color', $detailProduct->color) }}" required>
                            </div>

                            <div class="mb-6">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price', $detailProduct->price) }}" required>
                            </div>
                            <div class="text-end">
                                <a href="javascript:void(0);" class="btn btn-outline-primary me-1" onclick="window.history.back();">Kembali</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
