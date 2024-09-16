@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Tambah Detail Produk</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('detail-products.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="id_product" class="form-label">Produk</label>
                                <select name="id_product" id="id_product" class="form-control" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('id_product') == $product->id ? 'selected' : '' }}>>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="pcs" class="form-label">PCS</label>
                                <input type="number" id="pcs" name="pcs" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="dimension" class="form-label">Dimensi</label>
                                <input type="text" id="dimension" name="dimension" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Tipe</label>
                                <input type="text" id="type" name="type" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="color" class="form-label">Warna</label>
                                <input type="text" id="color" name="color" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
