@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="text-dark">Detail Product</h1>
        </div>

        <!-- Details Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Product Information</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><strong>Product ID:</strong> {{ $detailProduct->id }}</li>
                                <li><strong>Product Name:</strong> {{ $detailProduct->name }}</li>
                                <li><strong>Product:</strong> {{ $detailProduct->product->name }}</li>
                                <li><strong>PCS:</strong> {{ $detailProduct->pcs }}</li>
                                <li><strong>Dimension:</strong> {{ $detailProduct->dimension }}</li>
                                <li><strong>Type:</strong> {{ $detailProduct->type }}</li>
                                <li><strong>Color:</strong> {{ $detailProduct->color }}</li>
                                <li><strong>Price:</strong> ${{ number_format($detailProduct->price, 2) }}</li>
                            </ul>
                            <a href="{{ route('detail-products.edit', $detailProduct->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('detail-products.destroy', $detailProduct->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </button>
                            </form>
                            <a href="{{ route('detail-products.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
